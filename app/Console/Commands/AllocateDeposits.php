<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance;
use App\Models\Payment;
use DB;

class AllocateDeposits extends Command
{
    protected $signature = 'finances:allocate-deposits';
    protected $description = 'Allocate deposit payments (without finance_id) to partially unpaid finances';

    public function handle()
    {
        $this->info("Starting deposit allocation...");

        // Находим все finance, у которых есть непогашенный остаток
        // Остаток: finance->amount - sum(payments for this finance)
        // Можно сделать через запрос или в цикле.

        $finances = Finance::all()->filter(function($finance) {
            $paid = Payment::where('finance_id', $finance->id)->sum('amount');
            return $finance->amount > $paid; // Нужно ещё оплатить
        });

        if ($finances->isEmpty()) {
            $this->info("No partially unpaid finances found.");
            return 0;
        }

        foreach ($finances as $finance) {
            $this->allocateForFinance($finance);
        }

        $this->info("Deposit allocation completed.");
        return 0;
    }

    protected function allocateForFinance(Finance $finance)
    {
        $paid = Payment::where('finance_id', $finance->id)->sum('amount');
        $leftover = $finance->amount - $paid;

        if ($leftover <= 0) {
            // Уже оплачено или не нужно оплачивать
            return;
        }

        $projectId = $finance->project_id;

        // Находим депозиты этого проекта (finance_id = null)
        // Можно сортировать по дате или ID, чтобы было детерминировано.
        // Предположим сортируем по старшему ID или created_at:
        $deposits = Payment::where('project_id', $projectId)
            ->whereNull('finance_id')
            ->orderBy('created_at')
            ->get();

        // Пытаемся покрыть leftover этими депозитами
        foreach ($deposits as $deposit) {
            if ($leftover <= 0) {
                break;
            }

            // Сумма депозита
            $depositAmount = $deposit->amount;

            if ($depositAmount == 0) {
                // Пустой депозит - удаляем
                $deposit->delete();
                continue;
            }

            if ($depositAmount >= $leftover) {
                // Депозита хватает или он больше, чем нужно
                // Создаём payment для finance на сумму leftover
                Payment::create([
                    'finance_id' => $finance->id,
                    'project_id' => $projectId,
                    'amount' => $leftover,
                    'description' => $deposit->description . ' (Allocated from deposit)',
                ]);

                $depositAmountAfter = $depositAmount - $leftover;
                $leftover = 0;

                if ($depositAmountAfter == 0) {
                    // Депозит полностью израсходован
                    $deposit->delete();
                } else {
                    // Остаток депозита уменьшаем
                    $deposit->amount = $depositAmountAfter;
                    $deposit->save();
                }

            } else {
                // Депозита меньше, чем нужно, используем его полностью
                Payment::create([
                    'finance_id' => $finance->id,
                    'project_id' => $projectId,
                    'amount' => $depositAmount,
                    'description' => $deposit->description . ' (Allocated from deposit)',
                ]);

                $leftover -= $depositAmount;

                // Депозит исчерпан, удаляем
                $deposit->delete();
            }
        }

        // Если после цикла leftover всё ещё > 0, значит не хватило депозитов
        // Ничего не делаем, просто leftover остаётся не покрытым.
    }
}

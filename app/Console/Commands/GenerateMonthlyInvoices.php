<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Price;
use App\Models\Finance; // не забудьте добавить этот use
use Carbon\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate monthly invoices XML for all eligible projects';

    public function handle()
    {
        $currentDate = Carbon::now();
        $previousMonth = $currentDate->copy()->subMonth();

        $projects = Project::whereDate('paymanagir_start', '<=', $previousMonth->endOfMonth()->toDateString())->get();

        if ($projects->isEmpty()) {
            $this->info('No projects to invoice.');
            return;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<ExportedAccDocData xmlns="http://www.taxservice.am/tp3/invoice/definitions">';

        // Формируем строку месяца, например "December_2024"
        $monthStr = $previousMonth->format('F_Y');

        foreach ($projects as $project) {
            $finalPrice = $this->calculateProjectPriceForMonth($project, $previousMonth);

            $invoiceNumber = $this->generateInvoiceNumber($project);
            $series = 'B';
            $deliveryDate = $previousMonth->endOfMonth()->format('Y-m-d').'+04:00';

            // В реальном проекте подставьте реальные данные о покупателе.
            $buyerTin = $project->buyer_tin ?? '83565253';
            $buyerName = $project->firm_name ?? 'ՇԱՎԱՐՇ ԱԲՈՎՅԱՆ Անհատ ձեռնարկատեր (ԱՁ)';
            $buyerAddress = $project->buyer_address ?? 'ԼՈՌԻ ՎԱՆԱՁՈՐ ՎԱՆԱՁՈՐ ՄՅԱՍՆԻԿՅԱՆ Փ. 1 ԲՆ.23';

            $xml .= '
    <SignedAccDocData>
        <Data>
            <SignableData xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="1.0" xsi:type="AccountingDocument">
                <User>smartsec1</User>
                <Type>3</Type>
                <GeneralInfo>
                    <InvoiceNumber>
                        <Number>' . $invoiceNumber . '</Number>
                        <Series>' . $series . '</Series>
                    </InvoiceNumber>
                    <DeliveryDate>' . $deliveryDate . '</DeliveryDate>
                    <Procedure>1</Procedure>
                </GeneralInfo>
                <SupplierInfo>
                    <Taxpayer>
                        <TIN>06973829</TIN>
                        <Name>«ՍՄԱՌԹ» ՍՊԸ</Name>
                        <Address>ԼՈՌԻ ՎԱՆԱՁՈՐ ՎԱՆԱՁՈՐ ԱՂԱՅԱՆ Փ. 78/1 ԲՆ.7</Address>
                        <BankAccount>
                            <BankName>ԱՄԵՐԻԱԲԱՆԿ ՓԲԸ</BankName>
                            <BankAccountNumber>1570007469564600</BankAccountNumber>
                        </BankAccount>
                    </Taxpayer>
                </SupplierInfo>
                <OnBehalfOfSupplierInfo>
                    <Taxpayer>
                        <PrincipalTinNotRequired>false</PrincipalTinNotRequired>
                    </Taxpayer>
                </OnBehalfOfSupplierInfo>
                <BuyerInfo>
                    <Taxpayer>
                        <TIN>' . $buyerTin . '</TIN>
                        <Name>' . $buyerName . '</Name>
                        <Address>' . $buyerAddress . '</Address>
                        <TinNotRequired>false</TinNotRequired>
                        <IsNatural>false</IsNatural>
                    </Taxpayer>
                    <IsCitizenArmenia>false</IsCitizenArmenia>
                </BuyerInfo>
                <GoodsInfo>
                    <Good>
                        <Description>Հակահրդեհային անվտանգության տագնապի ազդանշանը ՀՀ ՆԳն փոխանցման ծառայություն</Description>
                        <Unit>հատ</Unit>
                        <Amount>1</Amount>
                        <PricePerUnit>' . $finalPrice . '</PricePerUnit>
                        <Price>' . $finalPrice . '</Price>
                        <TotalPrice>' . $finalPrice . '</TotalPrice>
                    </Good>
                    <Total>
                        <TotalPrice>' . $finalPrice . '</TotalPrice>
                    </Total>
                </GoodsInfo>
            </SignableData>
        </Data>
        <Signature>
            <SignatureType>PKCS7</SignatureType>
        </Signature>
        <AccDocMetadata>
            <SubmissionDate>' . now()->format('Y-m-d\TH:i:s.uP') . '</SubmissionDate>
        </AccDocMetadata>
    </SignedAccDocData>';

            // Добавляем запись в finances, но сначала проверим, не существует ли такая запись
            $existingFinance = Finance::where('project_id', $project->id)
                ->where('month', $monthStr)
                ->first();

            if (!$existingFinance) {
                Finance::create([
                    'project_id' => $project->id,
                    'month' => $monthStr,
                    'amount' => $finalPrice
                ]);
            }
        }

        $xml .= '</ExportedAccDocData>';

        $filename = 'invoices_' . $previousMonth->format('Y_m') . '.xml';
        $path = storage_path('app/public/' . $filename);
        file_put_contents($path, $xml);

        $this->info('Invoices generated: ' . $path);
    }

    protected function calculateProjectPriceForMonth($project, Carbon $monthDate)
    {
        $year = $monthDate->year;
        $month = $monthDate->month;
        $startDate = Carbon::parse($project->paymanagir_start);

        $priceModel = Price::find($project->price_id);
        if (!$priceModel) {
            return 0;
        }

        // Месячная ставка (используем поле amount)
        $monthlyAmount = $priceModel->amount;

        // Общее число дней в месяце
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        // Проверяем, является ли месяц частичным:
        if ($startDate->year == $year && $startDate->month == $month) {
            // Частичный месяц
            $startDay = $startDate->day;
            $daysUsed = $daysInMonth - $startDay + 1;
        } else {
            // Полный месяц
            $daysUsed = $daysInMonth;
        }

        // Итоговая цена пропорциональна доле дней:
        $finalPrice = ($monthlyAmount * $daysUsed) / $daysInMonth;

        return round($finalPrice, 2);
    }

    protected function generateInvoiceNumber($project)
    {
        return rand(1000000000, 9999999999);
    }
}

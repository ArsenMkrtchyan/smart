<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Price;
use App\Models\Finance; // не забудьте добавить этот use
use Carbon\Carbon;
use App\Models\State;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate monthly invoices XML for all eligible projects';

    public function handle()
    {
        $currentDate = Carbon::now();
        $previousMonth = $currentDate->copy()->subMonth();

//        $projects = Project::whereDate('paymanagir_start', '<=', $previousMonth->endOfMonth()->toDateString())->get();

//        $projects = Project::whereDate('paymanagir_start', '<=', $previousMonth->endOfMonth()->toDateString())
//            ->whereNotIn('object_check', ['սպասվող', 'Հրաժարված']) // Исключаем по строковым значениям
//            ->get();

        $projects = Project::whereDate('paymanagir_start', '<=', $previousMonth->endOfMonth()->toDateString())
            ->whereNotIn('object_check', [1, 2 ,3]) // Исключаем "սպասվող" и "Հրաժարված"
            ->get();


        if ($projects->isEmpty()) {
            $this->info('No projects to invoice.');
            return;
        }

        $xml = '<ExportedAccDocData xmlns="http://www.taxservice.am/tp3/invoice/definitions">';


        $monthStr = $previousMonth->format('F_Y');

        foreach ($projects as $project) {



            // Извлекаем дату из базы и преобразуем



            $state = State::find($project->i_marz_id);
            $marzName = $state ? $state->name : '';
            $districtName = $state ? $state->district : '';
            $finalPrice = $this->calculateProjectPriceForMonth($project, $previousMonth);

            $invoiceNumber = $this->generateInvoiceNumber($project);
            $series = 'B';
            $deliveryDate = $previousMonth->endOfMonth()->format('Y-m-d').'+04:00';



        if ($project->hvhh != null){
            $xml .= '<AccountingDocument Version="1.0">
    <Type>3</Type>
    <GeneralInfo>
      <DeliveryDate>' . $deliveryDate . '</DeliveryDate>
      <Procedure>1</Procedure>
    </GeneralInfo>
    <SupplierInfo>
      <Taxpayer>
        <TIN>06973829</TIN>
        <Name>«ՍՄԱՌԹ» Սահմանափակ պատասխանատվությամբ ընկերություն (ՍՊԸ)</Name>
        <Address>ԼՈՌԻ ՎԱՆԱՁՈՐ ՎԱՆԱՁՈՐ ԱՂԱՅԱՆ Փ. 78/1 ԲՆ.7</Address>
        <BankAccount>
          <BankName>ԱՄԵՐԻԱԲԱՆԿ  ՓԲԸ</BankName>
          <BankAccountNumber>1570047599065900</BankAccountNumber>
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
        <TIN>'.$project->hvhh.'</TIN>
      </Taxpayer>
      <IsCitizenArmenia>false</IsCitizenArmenia>
    </BuyerInfo>
    <GoodsInfo>
      <Good>
        <Description>Հակահրդեհային անվտանգության տագնապի ազդանշանը ՀՀ ՆԳն փոխանցման ծառայություն</Description>
        <Unit>հատ</Unit>
        <Amount>1</Amount>
        <PricePerUnit>'.$finalPrice.'</PricePerUnit>
        <Price>'.$finalPrice.'</Price>
        <TotalPrice>'.$finalPrice.'</TotalPrice>
      </Good>
      <Total>
        <TotalPrice>'.$finalPrice.'</TotalPrice>
      </Total>
    </GoodsInfo>
  </AccountingDocument>
  ';
        } elseif($project->hvhh == null and $project->andznagir != null){
$xml .= '<AccountingDocument Version="1.0">
    <Type>3</Type>
    <GeneralInfo>
      <DeliveryDate>'.$deliveryDate.'</DeliveryDate>
      <Procedure>1</Procedure>
    </GeneralInfo>
    <SupplierInfo>
      <Taxpayer>
        <TIN>06973829</TIN>
        <Name>«ՍՄԱՌԹ» Սահմանափակ պատասխանատվությամբ ընկերություն (ՍՊԸ)</Name>
        <Address>ԼՈՌԻ ՎԱՆԱՁՈՐ ՎԱՆԱՁՈՐ ԱՂԱՅԱՆ Փ. 78/1 ԲՆ.7</Address>
        <BankAccount>
          <BankName>ԱՄԵՐԻԱԲԱՆԿ  ՓԲԸ</BankName>
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
        <Passport>'.$project->andznagir.'</Passport>
        <PIDType>RA_PASSPORT</PIDType>
        <Name>'.$project->firm_name.'</Name>
        <Address>ՀՀ,մ․'.$marzName.','.$districtName.', '.$project->i_address.'</Address>
        <TinNotRequired>false</TinNotRequired>
        <IsNatural>true</IsNatural>
      </Taxpayer>
      <IsCitizenArmenia>false</IsCitizenArmenia>
    </BuyerInfo>
    <GoodsInfo>
      <Good>
        <Description>Հակահրդեհային անվտանգության տագնապի ազդանշանը ՀՀ ՆԳն փոխանցման ծառայություն</Description>
        <Unit>հատ</Unit>
        <Amount>1</Amount>
        <PricePerUnit>'.$finalPrice.'</PricePerUnit>
        <Price>'.$finalPrice.'</Price>
        <TotalPrice>'.$finalPrice.'</TotalPrice>
      </Good>
      <Total>
        <TotalPrice>'.$finalPrice.'</TotalPrice>
      </Total>
    </GoodsInfo>
  </AccountingDocument>';

        }elseif ($project->hvhh == null && $project->andznagir == null){
            $xml .= '<AccountingDocument Version="1.0">
    <Type>3</Type>
    <GeneralInfo>
      <DeliveryDate>'.$deliveryDate.'</DeliveryDate>
      <Procedure>1</Procedure>
    </GeneralInfo>
    <SupplierInfo>
      <Taxpayer>
        <TIN>06973829</TIN>
        <Name>«ՍՄԱՌԹ» Սահմանափակ պատասխանատվությամբ ընկերություն (ՍՊԸ)</Name>
        <Address>ԼՈՌԻ ՎԱՆԱՁՈՐ ՎԱՆԱՁՈՐ ԱՂԱՅԱՆ Փ. 78/1 ԲՆ.7</Address>
        <BankAccount>
          <BankName>ԱՄԵՐԻԱԲԱՆԿ  ՓԲԸ</BankName>
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
        <Passport>'.$project->id_card.'</Passport>
        <PIDType>ID_CARD</PIDType>
        <Name>'.$project->firm_name.'</Name>
         <Address>ՀՀ,մ․'.$marzName.','.$districtName.', '.$project->i_address.'</Address>
        <TinNotRequired>false</TinNotRequired>
        <IsNatural>true</IsNatural>
      </Taxpayer>
      <IsCitizenArmenia>false</IsCitizenArmenia>
    </BuyerInfo>
    <GoodsInfo>
      <Good>
        <Description>Հակահրդեհային անվտանգության տագնապի ազդանշանը ՀՀ ՆԳն փոխանցման ծառայություն</Description>
        <Unit>հատ</Unit>
        <Amount>1</Amount>
        <PricePerUnit>'.$finalPrice.'</PricePerUnit>
        <Price>'.$finalPrice.'</Price>
        <TotalPrice>'.$finalPrice.'</TotalPrice>
      </Good>
      <Total>
        <TotalPrice>'.$finalPrice.'</TotalPrice>
      </Total>
    </GoodsInfo>
  </AccountingDocument>';

        }





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

        return round($finalPrice, 0);
    }

    protected function generateInvoiceNumber($project)
    {
        return rand(1000000000, 9999999999);
    }
}

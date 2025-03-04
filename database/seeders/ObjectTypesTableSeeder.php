<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObjectTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objectTypes = [
            ['name' => 'Գազալցակայան'],
            ['name' => 'Բենզալցակայան'],
            ['name' => 'Խանութ'],
            ['name' => 'Սուպերմարկետ'],
            ['name' => 'Մթերային խանութ'],
            ['name' => 'Շինանյութի խանութ'],
            ['name' => 'Որսորդական խանութ'],
            ['name' => 'Էլ խանութ'],
            ['name' => 'Առևտրի կենտրոն'],
            ['name' => 'Գրախանութ'],
            ['name' => 'Գործարան'],
            ['name' => 'Թռչնաֆաբրիկա'],
            ['name' => 'Շաքարի գործարան'],
            ['name' => 'Գինու գործարան'],
            ['name' => 'Ջերմոց'],
            ['name' => 'Արտադրամաս'],
            ['name' => 'Շինարարական բազա'],
            ['name' => 'Հանքավայր'],
            ['name' => 'Հիվանդանոց'],
            ['name' => 'Բժշկական կենտրոն'],
            ['name' => 'Դեղատուն'],
            ['name' => 'Առողջարան'],
            ['name' => 'Բժշկական հաստատություն'],
            ['name' => 'Ատամնաբուժարան'],
            ['name' => 'Կլինիկա'],
            ['name' => 'Դպրոց'],
            ['name' => 'Երաժշտական դպրոց'],
            ['name' => 'Համալսարան'],
            ['name' => 'Մանկապարտեզ'],
            ['name' => 'Նախակրթարան'],
            ['name' => 'Կրթահամալիր'],
            ['name' => 'Մարզադպրոց'],
            ['name' => 'Թատրոն'],
            ['name' => 'Թանգարան'],
            ['name' => 'Պատկերասրահ'],
            ['name' => 'Ժամանցային համալիր'],
            ['name' => 'Ակումբ'],
            ['name' => 'Հանդիսությունների սրահ'],
            ['name' => 'Խաղասրահ'],
            ['name' => 'Մանկական զվարճանքների կենտրոն'],
            ['name' => 'Սրճարան'],
            ['name' => 'Ռեստորան'],
            ['name' => 'Արագ սնունդ'],
            ['name' => 'Խորովածանոց'],
            ['name' => 'Հանրային սննդի օբյեկտ'],
            ['name' => 'Բանկ'],
            ['name' => 'Վարկային կազմակերպություն'],
            ['name' => 'Ապահովագրական ընկերություն'],
            ['name' => 'Տարադրամի փոխանակման կետ'],
            ['name' => 'Գրավատուն'],
            ['name' => 'Համայնքապետարան'],
            ['name' => 'Գյուղապետարան'],
            ['name' => 'Մաքսային հսկողության տարածք'],
            ['name' => 'Գրասենյակային տարածք'],
            ['name' => 'Ավտոկայանատեղի'],
            ['name' => 'Հյուրանոց'],
            ['name' => 'Բիզնես կենտրոն'],
            ['name' => 'Հյուրատուն'],
            ['name' => 'Պահեստ'],
            ['name' => 'Ավտոսպասարկման կենտրոն'],
            ['name' => 'Տուրիստական գործակալություն'],
            ['name' => 'Եկեղեցի'],
            ['name' => 'Լաբորատորիա'],
            ['name' => 'Հրաձգարան'],
            ['name' => 'Հրատարակչություն'],
            ['name' => 'Բնակելի շենք'],
            ['name' => 'Տպարան'],
        ];

        DB::table('object_types')->insert($objectTypes);
    }
}

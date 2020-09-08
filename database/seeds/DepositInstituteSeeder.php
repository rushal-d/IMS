<?php

use App\InvestmentInstitution;
use Illuminate\Database\Seeder;

class DepositInstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deposit_id = \App\InvestmentType::InvestmenttypeDeposit();
        InvestmentInstitution::where('invest_type_id','=',$deposit_id)->delete();
        $kha1 = \App\InvestmentGroup::isKHA_1();
        $kha2 = \App\InvestmentGroup::isKHA_2();
        $kha3 = \App\InvestmentGroup::isKHA_3();

///////////////////////////KHA-1/////////////////////////////////////////////////////////////////
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Prabhu Bank Limited',
            'institution_code' => 'PBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Rastriya Banijya Bank Limited',
            'institution_code' => 'RBBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Bank',
            'institution_code' => 'NB',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Agriculture Development Bank Limited',
            'institution_code' => 'ADBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Prabhu Bank Limited',
            'institution_code' => 'PBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nabil Bank Limited',
            'institution_code' => 'NBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Investment Bank Limited',
            'institution_code' => 'NIBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Standard Chartered Bank Nepal Limited',
            'institution_code' => 'SCBNL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Himalayan Bank Limited',
            'institution_code' => 'HBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal SBI Bank Limited',
            'institution_code' => 'NSBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Bangladesh Bank Limited',
            'institution_code' => 'NBB',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Everest Bank Limited',
            'institution_code' => 'EBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Kumari Bank Limited',
            'institution_code' => 'KBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Bank of Kathmandu Limited',
            'institution_code' => 'BOKL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
       /* InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Credit and Commerce Bank Limited',
            'institution_code' => 'NCCBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);*/
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Global IME Bank Limited',
            'institution_code' => 'GIBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Citizens Bank International Limited',
            'institution_code' => 'CBIL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Prime Commercial Bank Limited',
            'institution_code' => 'PCBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Sunrise Bank Limited',
            'institution_code' => 'SBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'NMB Bank Limited',
            'institution_code' => 'NMBBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'NIC Asia Bank Limited',
            'institution_code' => 'NABL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Machhapuchhre Bank Limited',
            'institution_code' => 'MBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Mega Bank Nepal Limited',
            'institution_code' => 'MBNL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Civil Bank Limited',
            'institution_code' => 'CBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Century Bank Limited',
            'institution_code' => 'CTBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Sanima Bank Limited',
            'institution_code' => 'SBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Laxmi Bank Limited',
            'institution_code' => 'LBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Janata Bank Nepal Limited',
            'institution_code' => 'JBNL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Siddhartha Bank Limited',
            'institution_code' => 'SHBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Credit & Commerce Bank Limited',
            'institution_code' => 'NCCBL',
            'description' => '',
            'invest_group_id' => $kha1,
            'invest_type_id' => $deposit_id,
        ]);

/////////////////////////////KHA-2//////////////////////////////////////////////////////////
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Narayani Development Bank Limited',
            'institution_code' => 'NDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Sahayogi Bikas Bank Limited',
            'institution_code' => 'SBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Karnali Bikas Bank Limited',
            'institution_code' => 'KBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Excel Development Bank Limited',
            'institution_code' => 'EDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Miteri Development Bank Limited',
            'institution_code' => 'MDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Tinau Bikas Bank Limited',
            'institution_code' => 'TBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Muktinath Bikas Bank Ltd',
            'institution_code' => 'MBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Kankai Bikas Bank Limited',
            'institution_code' => 'KBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Bhargav Bikash Bank Limited',
            'institution_code' => 'BBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Corporate Development Bank Limited',
            'institution_code' => 'CDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Kabeli Bikas Bank Limited',
            'institution_code' => 'KBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Purnima Bikas Bank Limited',
            'institution_code' => 'PBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Hamro Bikas Bank Limited',
            'institution_code' => 'HBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Kanchan Development Bank Limited',
            'institution_code' => 'KDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Mission Development Bank Limited',
            'institution_code' => 'MDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Mount Makalu Development Bank Limited',
            'institution_code' => 'MMDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Sindhu Bikas Bank Limited',
            'institution_code' => 'SBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Sahara Development Bank Limited',
            'institution_code' => 'SDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Community Development Bank Limited',
            'institution_code' => 'NCDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Salapa Development Bank Limited',
            'institution_code' => 'SDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Saptakoshi Development Bank Limited',
            'institution_code' => 'SDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Green Development Bank Limited',
            'institution_code' => 'GDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Shangri-la Development Bank Limited',
            'institution_code' => 'SLDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Deva Bikas Bank Limited',
            'institution_code' => 'DDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Kailash Development Bank Limited',
            'institution_code' => 'KDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Shine Resunga Development Bank Limited',
            'institution_code' => 'DRDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Jyoti Bikas Bank Limited',
            'institution_code' => 'JBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Garima Bikas Bank Limited',
            'institution_code' => 'GBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Om Development Bank Limited',
            'institution_code' => 'ODBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Mahalaxmi Development Bank Limited',
            'institution_code' => 'MDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Gandaki Bikas Bank Limited',
            'institution_code' => 'GBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Lumbini Bikas Bank Limited',
            'institution_code' => 'LBBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Kamana Sewa Bikas Bank Limited',
            'institution_code' => '',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Western Development Bank Limited',
            'institution_code' => 'WDBL',
            'description' => '',
            'invest_group_id' => $kha2,
            'invest_type_id' => $deposit_id,
        ]);
///////////////////////////KHA-3////////////////////////////////////////////////////
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Finance Limited',
            'institution_code' => 'NFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Nepal Share Markets and Finance Limited',
            'institution_code' => 'NSMAFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Goodwill Finance Limited',
            'institution_code' => 'GFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Lalitpur Finance Co. Limited',
            'institution_code' => 'LFCL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'United Finance Limited',
            'institution_code' => 'UFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Best Finance Limited',
            'institution_code' => 'BFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Progressive Finance Limited',
            'institution_code' => 'PFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Janaki Finance Co. Limited',
            'institution_code' => 'JFCL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Pokhara Finance Limited',
            'institution_code' => 'PFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Hathway Finance Limited',
            'institution_code' => 'HFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Multipurpose Finance Co. Ltd',
            'institution_code' => 'MFCL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Shrijana Finance Limited',
            'institution_code' => 'SFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'World Merchant Banking & Finance Limited',
            'institution_code' => 'WMBFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Capital Merchant Banking & Finance Co. Limited',
            'institution_code' => 'CMBFCL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Crystal Finance Limited',
            'institution_code' => 'CSFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Guheshwori Merchant Banking & Finance Limited',
            'institution_code' => 'GMBFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'ICFC Finance Limited',
            'institution_code' => 'ICFCFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'City Express Finance Co. Limited',
            'institution_code' => 'CEFCL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Manjushree Finance Limited',
            'institution_code' => 'MFIL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Jebil\'s Finance Limited',
            'institution_code' => 'JFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Reliance Finance Limited',
            'institution_code' => 'RFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Gurkhas Finance Limited',
            'institution_code' => 'GFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Himalaya Finance Limited',
            'institution_code' => 'HFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Shree Investment & Finance Co. Ltd.',
            'institution_code' => 'SIFCL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
        InvestmentInstitution::firstOrCreate([
            'institution_name' => 'Central Finance Limited',
            'institution_code' => 'CFL',
            'description' => '',
            'invest_group_id' => $kha3,
            'invest_type_id' => $deposit_id,
        ]);
    }
}

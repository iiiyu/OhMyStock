<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $s_p_500_symbols = ['ABT', 'ABB', 'ABM', 'ACN', 'ATV', 'ADB', 'AMD', 'AAP', 'AES', 'AFL', 'A', 'APD', 'AKA', 'ALK', 'ALB', 'ARE', 'ALX', 'ALG', 'ALL', 'ALL', 'AMZ', 'AMC', 'AEE', 'AAL', 'AEP', 'AXP', 'AIG', 'AMT', 'AWK', 'AMP', 'ABC', 'AME', 'AMG', 'APH', 'ADI', 'ANS', 'ANT', 'AON', 'AOS', 'APA', 'AIV', 'AAP', 'AMA', 'APT', 'ADM', 'ANE', 'AJG', 'AIZ', 'ATO', 'ADS', 'ADP', 'AZO', 'AVB', 'AVY', 'AVG', 'BKR', 'BLL', 'BAC', 'BK', 'BAX', 'BDX', 'BRK', 'BBY', 'BIO', 'BII', 'BLK', 'BA', 'BKN', 'BWA', 'BXP', 'BSX', 'BMY', 'BR', 'BF.A', 'BF.B', 'BEN', 'CHR', 'COG', 'CDN', 'CPB', 'COF', 'CAH', 'CCL', 'CAR', 'CAT', 'CBO', 'CBR', 'CDW', 'CE', 'CNC', 'CNP', 'CTL', 'CER', 'CF', 'CHT', 'CVX', 'CMG', 'CB', 'CHD', 'CI', 'CIN', 'CTA', 'CSC', 'C', 'CFG', 'CTX', 'CLX', 'CME', 'CMS', 'CTS', 'CL', 'CMC', 'CMA', 'CAG', 'CXO', 'COP', 'COO', 'CPR', 'CTV', 'COS', 'COT', 'CCI', 'CSX', 'CMI', 'CVS', 'CRM', 'DHI', 'DHR', 'DRI', 'DVA', 'DE', 'DAL', 'DVN', 'DXC', 'DLR', 'DFS', 'DIS', 'DIS', 'DIS', 'DG', 'DLT', 'D', 'DPZ', 'DOV', 'DOW', 'DTE', 'DUK', 'DRE', 'DD', 'DXC', 'DGX', 'DIS', 'ED', 'EMN', 'ETN', 'EBA', 'ECL', 'EIX', 'EW', 'EA', 'EMR', 'ETR', 'EOG', 'EFX', 'EQI', 'EQR', 'ESS', 'EL', 'EVR', 'ES', 'EXC', 'EXP', 'EXP', 'EXR', 'FAN', 'FFI', 'FB', 'FAS', 'FRT', 'FDX', 'FIS', 'FIT', 'FE', 'FRC', 'FIS', 'FLT', 'FLI', 'FLS', 'FMC', 'F', 'FTN', 'FTV', 'FBH', 'FOX', 'FOX', 'FCX', 'FTI', 'GOO', 'GOO', 'GLW', 'GPS', 'GRM', 'GD', 'GE', 'GIS', 'GM', 'GPC', 'GIL', 'GL', 'GPN', 'GS', 'GWW', 'HRB', 'HAL', 'HBI', 'HIG', 'HAS', 'HCA', 'HSI', 'HSY', 'HES', 'HPE', 'HLT', 'HFC', 'HOL', 'HD', 'HON', 'HRL', 'HST', 'HWM', 'HPQ', 'HUM', 'HII', 'IT', 'IEX', 'IDX', 'INF', 'ITW', 'INC', 'IR', 'INT', 'ICE', 'IBM', 'IP', 'IPG', 'IFF', 'INT', 'ISR', 'IVZ', 'IPG', 'IQV', 'IRM', 'JKH', 'J', 'JNJ', 'JCI', 'JPM', 'JNP', 'KMX', 'KO', 'KSU', 'K', 'KEY', 'KEY', 'KMB', 'KIM', 'KMI', 'KLA', 'KSS', 'KHC', 'KR', 'LNT', 'LB', 'LHX', 'LH', 'LRC', 'LW', 'LVS', 'LEG', 'LDO', 'LEN', 'LLY', 'LNC', 'LIN', 'LYV', 'LKQ', 'LMT', 'L', 'LOW', 'LYB', 'LUV', 'MMM', 'MO', 'MTB', 'MRO', 'MPC', 'MKT', 'MAR', 'MMC', 'MLM', 'MAS', 'MA', 'MKC', 'MXI', 'MCD', 'MCK', 'MDT', 'MRK', 'MET', 'MTD', 'MGM', 'MCH', 'MU', 'MSF', 'MAA', 'MHK', 'MDL', 'MNS', 'MCO', 'MS', 'MOS', 'MSI', 'MSC', 'MYL', 'NDA', 'NOV', 'NTA', 'NFL', 'NWL', 'NEM', 'NWS', 'NWS', 'NEE', 'NLS', 'NKE', 'NI', 'NBL', 'NSC', 'NTR', 'NOC', 'NLO', 'NCL', 'NRG', 'NUE', 'NVD', 'NVR', 'NOW', 'ORL', 'OXY', 'ODF', 'OMC', 'OKE', 'ORC', 'OTI', 'O', 'PCA', 'PKG', 'PH', 'PAY', 'PAY', 'PYP', 'PNR', 'PBC', 'PEP', 'PKI', 'PRG', 'PFE', 'PM', 'PSX', 'PNW', 'PXD', 'PNC', 'PPG', 'PPL', 'PFG', 'PG', 'PGR', 'PLD', 'PRU', 'PEG', 'PSA', 'PHM', 'PVH', 'PWR', 'RE', 'RL', 'RJF', 'RTX', 'REG', 'REG', 'RF', 'RSG', 'RMD', 'RHI', 'ROK', 'ROL', 'ROP', 'ROS', 'RCL', 'STZ', 'SJM', 'SPG', 'SLB', 'STX', 'SEE', 'SRE', 'SHW', 'SPG', 'SWK', 'SLG', 'SNA', 'SO', 'SWK', 'SBU', 'STT', 'STE', 'SYK', 'SIV', 'SYF', 'SNP', 'SYY', 'T', 'TAP', 'TMU', 'TRO', 'TTW', 'TPR', 'TGT', 'TEL', 'TDY', 'TFX', 'TXN', 'TXT', 'TMO', 'TIF', 'TJX', 'TSC', 'TT', 'TDG', 'TRV', 'TFC', 'TWT', 'TYL', 'TSN', 'UDR', 'ULT', 'USB', 'UAA', 'UA', 'UNP', 'UAL', 'UNH', 'UPS', 'URI', 'UHS', 'UNM', 'VFC', 'VLO', 'VAR', 'VTR', 'VRS', 'VRS', 'VZ', 'VRT', 'VIA', 'V', 'VNO', 'VMC', 'WRB', 'WAB', 'WMT', 'WBA', 'WM', 'WAT', 'WEC', 'WFC', 'WEL', 'WST', 'WDC', 'WU', 'WRK', 'WY', 'WHR', 'WMB', 'WLT', 'WYN', 'XRA', 'XOM', 'XEL', 'XRX', 'XYL', 'YUM', 'ZBH', 'ZTS'];


    public function run()
    {

        // 加入 VTI
        $this->s_p_500_symbols[] = 'VTI';
        $data = [];
        foreach ($this->s_p_500_symbols as $value) {
            $data[] = ['symbol' => $value, 'name' => $value];
        }

        try {
            DB::beginTransaction();
            Company::upsert($data, ['symbol'], ['name']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

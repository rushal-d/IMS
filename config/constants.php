<?php
return [
    'kb_url' => 'http://3dprintnepal.com/kbbackend/public/index.php',
    'investment_type' => [
        '1' => "Bond",
        '2' => "Deposit",
        '3' => "Share",
    ],
    'deposit_status' => [
        1 => 'Active',
        2 => 'Renew Soon',
        3 => 'Expired',
        4 => 'Renewed',
        5 => 'Withdrawn',
    ],
    'bond_status' => [
        1 => 'Active',
        2 => 'Renew Soon',
        3 => 'Expired',
    ],
    'investment_payment_methods' => [
        'Monthly',
        'Quarterly',
        'Half Yearly',
        'Annually',
        'Lump Sum',
    ],
    'earmarked' => [
        "No",
        "Yes"
    ],
    'master_share_type' => [
        1 => 'IPO',
        2 => 'Promotor',
        3 => 'Secondary',
        4 => 'Bonus',
        5 => 'Right',
        6 => 'Sale',
    ],
    'mature_days_filter' => [
        '10' => '<=10 days',
        '25' => '<=25 days',
        '30' => '<=30 days',
        '60' => '<=60 days',
        '90' => '<=90 days',
        '100' => '<=100 days',
        '200' => '<=200 days',
        '300' => '<=300 days',
        '301' => '<=301 days',
    ],
    'quaters' => [
        'first' => [4, 6],
        'second' => [7, 9],
        'third' => [10, 12],
        'fourth' => [1, 3],
    ],

    'alert_email_days' => 5,
    'investment_areas' => [
        '1' => 'Agriculture',
        '2' => 'Tourism',
        '3' => 'Water Resources',
        '4' => 'Others',
    ],
    'fd_document_lcoations' => [
        'NO RECEIPT',
        'COPY',
        'ONLINE',
        'BSIB',
        env('ORG_CODE', 'Head Office'),
        'EMAIL',
        'RETURNED',
    ],
    'receipt_location' => [
        'COPY',
        'FILE',
        'Certificate',
    ],
    'investment_request_status' => [
        'Pending',
        'Disapporved',
        'Approved',
    ],
    'investment_through' => [
        '1' => 'Cash',
        '2' => 'Loan',
        '3' => 'Sale',
        '4' => 'Loan Clear',
    ],
    'land_building_investment_type' => [
        '1' => 'Purchase',
        '2' => 'Sale',
    ],
    'nepali_fiscal_year_months' => [
        4 => 'Sharwan',
        5 => 'Bhadra',
        6 => 'Asoj',
        7 => 'Kartik',
        8 => 'Mangshir',
        9 => 'Paush',
        10 => 'Magh',
        11 => 'Falgun',
        12 => 'Chaitra',
        1 => 'Baisakh',
        2 => 'Jestha',
        3 => 'Ashar',
    ],
    'count_start_day_int_calc' => false, //fiscal year break counting both start days, prevent counting start day
    'deposit_export_fields' => [
        'SN',
        'Fiscal Year',
        'Bank Name',
        'Bank Branch',
        'Organization Branch',
        'FD No.',
        'Interest Rate',
        'Transaction Date',
        'Transaction Date (BS)',
        'Duration (days)',
        'Mature Days',
        'Mature Days (BS)',
        'Opening Amount',
        'Renew Amount',
        'Withdrawn Amount',
        'Estimated Earning',
        'Interest Payment Method',
        'Investment Sector',
        'Actual Earning',
        'Status',
        'Cheque Number',
        'Reference Number',
        'Interest Credited Bank',
        'Interest Credited Bank Branch',
        'Account Number',
        'Notes',
        'Receipt Number',
        'Staff Name',
        'Credit Date',
        'Credit Date (BS)',
        'Cheque Date',
        'Cheque Date (BS)',
        'Narration',
        'Voucher Number',
        'FD Current Location',
        'Bank Contact Person',
        'Earmarked',
    ],
    'excel_column_title' => [
        'A', 'B', 'C', 'D', 'E',
        'F', 'G', 'H', 'I', 'J',
        'K', 'L', 'M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T',
        'U', 'V', 'W', 'X', 'Y',
        'Z',
        'AA', 'AB', 'AC', 'AD', 'AE',
        'AF', 'AG', 'AH', 'AI', 'AJ',
        'AK', 'AL', 'AM', 'AN', 'AO',
        'AP', 'AQ', 'AR', 'AS', 'AT',
        'AU', 'AV', 'AW', 'AX', 'AY',
        'AZ',
    ]
];
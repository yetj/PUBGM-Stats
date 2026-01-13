<?
$dateNow = new DateTime();

$PMPLday1 = ['W1D1' => 'on'];
$PMPLday2 = array_merge($PMPLday1, ['W1D2' => 'on']);
$PMPLday2a = array_merge($PMPLday2, ['W1D3' => 'on']);
$PMPLday3 = array_merge($PMPLday2a, ['SW1D1' => 'on']);
$PMPLday4 = array_merge($PMPLday3, ['SW1D2' => 'on']);
$PMPLday5 = array_merge($PMPLday4, ['SW1D3' => 'on']);
$PMPLday6 = array_merge($PMPLday5, ['W2D1' => 'on']);
$PMPLday7 = array_merge($PMPLday6, ['W2D2' => 'on']);
$PMPLday7a = array_merge($PMPLday7, ['W2D3' => 'on']);
$PMPLday8 = array_merge($PMPLday7a, ['SW2D1' => 'on']);
$PMPLday9 = array_merge($PMPLday8, ['SW2D2' => 'on']);
$PMPLday10 = array_merge($PMPLday9, ['SW2D3' => 'on']);
$PMPLday11 = array_merge($PMPLday10, ['W3D1' => 'on']);
$PMPLday12 = array_merge($PMPLday11, ['W3D2' => 'on']);
$PMPLday12a = array_merge($PMPLday12, ['W3D3' => 'on']);
$PMPLday13 = array_merge($PMPLday12a, ['SW3D1' => 'on']);
$PMPLday14 = array_merge($PMPLday13, ['SW3D2' => 'on']);
$PMPLday15 = array_merge($PMPLday14, ['SW3D3' => 'on']);
$PMPLday16 = array_merge($PMPLday15, ['FinalsD1' => 'on']);
$PMPLday17 = array_merge($PMPLday16, ['FinalsD2' => 'on']);
$PMPLday18 = array_merge($PMPLday17, ['FinalsD3' => 'on']);

$PMPLnewDay1 = ['P1D1' => 'on'];
$PMPLnewDay2 = array_merge($PMPLnewDay1, ['P1D2' => 'on']);
$PMPLnewDay3 = array_merge($PMPLnewDay2, ['P1D3' => 'on']);
$PMPLnewDay4 = array_merge($PMPLnewDay3, ['P1D4' => 'on']);
$PMPLnewDay5 = array_merge($PMPLnewDay4, ['P1D5' => 'on']);
$PMPLnewDay6 = array_merge($PMPLnewDay5, ['P1D6' => 'on']);
$PMPLnewDay7 = array_merge($PMPLnewDay6, ['P2D1' => 'on']);
$PMPLnewDay8 = array_merge($PMPLnewDay7, ['P2D2' => 'on']);
$PMPLnewDay9 = array_merge($PMPLnewDay8, ['P2D3' => 'on']);
$PMPLnewDay10 = array_merge($PMPLnewDay9, ['P2D4' => 'on']);
$PMPLnewDay11 = array_merge($PMPLnewDay10, ['P2D5' => 'on']);
$PMPLnewDay12 = array_merge($PMPLnewDay11, ['P2D6' => 'on']);
$PMPLnewDay13 = array_merge($PMPLnewDay12, ['P3D1' => 'on']);
$PMPLnewDay14 = array_merge($PMPLnewDay13, ['P3D2' => 'on']);
$PMPLnewDay15 = array_merge($PMPLnewDay14, ['P3D3' => 'on']);
$PMPLnewDay16 = array_merge($PMPLnewDay15, ['P3D4' => 'on']);
$PMPLnewDay17 = array_merge($PMPLnewDay16, ['P3D5' => 'on']);
$PMPLnewDay18 = array_merge($PMPLnewDay17, ['P3D6' => 'on']);
$PMPLnewDay19 = array_merge($PMPLnewDay18, ['FinalsD1' => 'on']);
$PMPLnewDay20 = array_merge($PMPLnewDay19, ['FinalsD2' => 'on']);
$PMPLnewDay21 = array_merge($PMPLnewDay20, ['FinalsD3' => 'on']);

$PMCOday1 = ['Day1' => 'on'];
$PMCOday2 = array_merge($PMCOday1, ['Day2' => 'on']);
$PMCOday3 = array_merge($PMCOday2, ['Day3' => 'on']);
$PMCOday4 = array_merge($PMCOday3, ['Day4' => 'on']);
$PMCOday5 = array_merge($PMCOday4, ['Day5' => 'on']);
$PMCOday6 = array_merge($PMCOday5, ['Day6' => 'on']);
$PMCOday7 = array_merge($PMCOday6, ['Day7' => 'on']);
$PMCOday8 = array_merge($PMCOday7, ['Day8' => 'on']);
$PMCOdayPlayins = array_merge($PMCOday3, ['Play-ins' => 'on']);


$PMWCday1 = ['GroupStageD1' => 'on'];
$PMWCday2 = array_merge($PMWCday1, ['GroupStageD2' => 'on']);
$PMWCday3 = array_merge($PMWCday2, ['GroupStageD3' => 'on']);
$PMWCday4 = array_merge($PMWCday3, ['SurvivalStageD1' => 'on']);
$PMWCday5 = array_merge($PMWCday4, ['SurvivalStageD2' => 'on']);
$PMWCday6 = array_merge($PMWCday5, ['MainTournamentD1' => 'on']);
$PMWCday7 = array_merge($PMWCday6, ['MainTournamentD2' => 'on']);
$PMWCday8 = array_merge($PMWCday7, ['MainTournamentD3' => 'on']);

$newRegions = [
	'PMSL_2024_EMEA_Fall' => '1',
	'PMSL_2024_EU_Fall' => '1',
	'PMWC_2024' => '1',
	'PMWC_2024' => '1',
	'PMSL_2024_EMEA_Spring' => '1',
	'PMSL_2024_EU_Spring' => '1',
	'PMSL_2024_MEA1_Spring' => '1',
	'PMSL_2024_MEA2_Spring' => '1',
	'PMSL_2024_MEAF_Spring' => '1',
	'PMPL_CS_2023_AM_Fall' => '1',
	'PMPL_CS_2023_MEA_Fall' => '1',
	'PMPL_CS_2023_EU_Fall' => '1',
	'PMPL_TR_2023_Fall' => '1',
	'PMPL_EU_2023_Fall' => '1',
	'PMPL_AF_2023_Fall' => '1',
	'PMPL_NA_2023_Fall' => '1',
	'PMPL_AR_2023_Fall' => '1',
	'PMRC_2023_MEACS_EUCS' => '1',
	'PMPL_CS_2023_MEA_Spring' => '1',
	'PMPL_CS_2023_EU_Spring' => '1',
	'PMPL_CS_2023_AM_Spring' => '1',
	'PMPL_AR_2023_Spring' => '1',
	'PMPL_EU_2023_Spring' => '1',
	'PMPL_AF_2023_Spring' => '1',
	'PMPL_NA_2023_Spring' => '1',
	'PMPL_WEU_2022_Fall' => '1',
	'PMPL_TR_2022_Fall' => '1',
	'PMPL_NA_2022_Fall' => '1',
	'PMPL_AF_2022_Fall' => '1'
];

$regions = [


	'PMSL_2024_EMEA_Fall' => '15yK0HFkOEplizjcqLnuIO1HIxb9V1xse8clegNA3XBk',

	'PMSL_2024_EU_Fall' => '1rw6MMY70BFivlkc6N_59TH4bNcsalB03ID4MB9wqY68',
	
	'PMWC_2024' => '1uLk96-bsZIyyn_Q9wCBldZ1FxII718Xe0oWsfl1Rm7I',

	'PMSL_2024_EMEA_Spring' => '1JmDjzm3SNz3_rfhuKTKXZmj-1VUntn26HqYl5-N3a90',

	'PMSL_2024_EU_Spring' => '1kqXMUoJuQoco5-8NT7nG_un3t7axLp1Js51d5SfX6lk',
	'PMSL_2024_MEA1_Spring' => '1kCAsaPQi8mE4sNyf1rpMt_djExXpXZH9j8NuxHIbo_o',
	'PMSL_2024_MEA2_Spring' => '18sBwFqSenY1AH5YDAMLhwSY_ZRmF6Y3JWTyDvn4cKgc',
	'PMSL_2024_MEAF_Spring' => '1lMTPzkSISjS9fb1QIbccXPioJ1u20rluPRwKf7f-ucY',

	'PMPL_CS_2023_AM_Fall' => '1_hGyUr9hbzDdStiZ-P085qu--EV6-gdrp0wj1tftc0I',
	'PMPL_CS_2023_MEA_Fall' => '1pUhFJIR5lKkrC_u2ILCXKJyBa_Yvtpb9V0OUVnvBI7U',
	'PMPL_CS_2023_EU_Fall' => '1J0KwjL8gZdket6dRULv8yXi_kAr8A-eDidNIGyBcEQE',

	//'testx' => '1ZGhqyzjxwMpctv36qj7dt6VAD71giPZBNvwBINchnOU',
	'PMPL_TR_2023_Fall' => '1rrPyZMNDZjo_clD8UiZE2YYimVuVJ4iPRHzIu9umrQk',
	'PMPL_AF_2023_Fall' => '1SSrft8sgDP35KSACWZ6Avg8fMUdL_iF0APAYp5ob5B0',
	'PMPL_EU_2023_Fall' => '1r-in0Il-0AzVkhHVWVpC0RFWKlg5MvLqlIN_KUmcDBg',
	'PMPL_NA_2023_Fall' => '1gZ3ASSz3MU27nNl8Tz1pwrS8wQZFVOCC11W2qraM4L0',
	'PMPL_AR_2023_Fall' => '1c9qk1ec6Kl96EV3MqX2_EjEIibHfXqdjuyGO6wo01f8',
	
	'PMRC_2023_MEACS_EUCS' => '1r8i6OJ4Ttm3LNUpv6pyJSFZYPMbXu73Ii-YGWD7vqf0',
	'PMWI_2023_MainTournament' => '1qBTEsCJLwQbX1e0jORJXW34TufLuO7v7CFQMl-8O4-0',
	'PMWI_2023_Allstars' => '1-jOAKb-ClJvdrM4C_HtI80y4jTN9begcmIYUNYA1K04',

	'PMPL_CS_2023_MEA_Spring' => '1fXoVV6fujqSIjrGzb68VRqDO43gO10E7Gd-AprKhOsQ',
	'PMPL_CS_2023_EU_Spring' => '1FZ6vJdoWzZfatNu28_mFPpCSdolpl8KaM0T6POzpNGM',
	'PMPL_CS_2023_AM_Spring' => '1v3HBKYEmdvxkE2hxdRlHJQT7qlKuTW-_kkEF4EV7p7Y',

	'PMPL_AR_2023_Spring' => '1eq_DMx8LvIUQ8dEIpPHlAKhNMh9_5Vhx1i6aYtoKYp8',
	'PMPL_EU_2023_Spring' => '1jq0Rl7-jFLNSVT2AQmy9U-gGbBThuFAU8QW9HP1X5hU',
	'PMPL_TR_2023_Spring' => '1kw4rvEe0Typn3wevzHS1H7WR3TxjUI9WwlwVdXB4Aww',
	'PMPL_AF_2023_Spring' => '1vPLp-wzjOCQ9q82X2uptwQdRBkByS0Eyxp3hHKTEjMw',
	'PMPL_NA_2023_Spring' => '1Z5jxKtupOX-8ZJMea3yjsk2XMppLwm-Owr5i1yd26oY',
	
	'PMPL_CS_2022_EU_Fall' => '18zUNWM-nyRs30K_nR7tVq-igeDR7vRQsxcNARsYrm80',
	'PMPL_CS_2022_AM_Fall' => '1kHHMSkqs_5GCmL1KhxGb9q5pCdJ37GtGNhflMHCCrRg',
	'PMPL_CS_2022_MEA_Fall' => '1qc1nnHZvUiYBUyqQnLHtl7ah8a8PMj_oCJVir2YzNbY',
	
	'PMPL_WEU_2022_Fall' => '10XWM4LkBbym2N_NEyDJtJfoNxSAzW293E_2IUxUc4Gk',
	'PMPL_TR_2022_Fall' => '1CEeWxHzKTTt8OtUrv3dV_oHG7HmhH3h3Y9c3BjjiAH4',
	'PMPL_NA_2022_Fall' => '1K3usbyMnw8sK5CUy8u6YzAdlqF3jTVy661Z5x9jzq1w',
	'PMPL_AF_2022_Fall' => '1ZJkVksQsP-VOPMCph9NyymxMj8dafFGIzTur8t-oKzg',

	'PMWI_Week_2' => '1N5pXZ78cJ5eNCHxzfrjjhg7_GHbDgv-yjbYl9w_kYj4',
	'PMWI_Week_2_DUO' => '1ezicFQmlLZA3CsqfCvFpIUdgvhckBxr5BTIQwhLoy5c',
	'PMWI_Week_1' => '1-tPNxGsHofAopvwclpBhbvpkdNcQnxAJRi_rQz7QN9Y',
	
	'PMPL_AR_2022_Fall' => '1Bs2etn1rhXxa_1Uw0wD1VNbtRz_wxW893uOxPPBOr4g',
	
	'PMPL_CS_2022_AM' => '14Cz5BzfpLxx5bJcbHlzz2B7zJrvJzrIy26NFGzbaeck',
	'PMPL_CS_2022_EU' => '1MDJc3LPQi6WaxiIdy3OitR9HICiyz2J2ihKV4-cZkaQ',
	'PMPL_CS_2022_MEA' => '1_qg8LCF8xLjl80hZ_5pHjtSd2wntBS6_nFXGuWI2BI0',
	
	'PMPL_AF_2022_Spring' => '1-plbgsAh7_vrCs-2IWwZNMK1fHsoNzd64usVDvuvRNU',
	'PMPL_AR_2022_Spring' => '1oq30eXL6eCfhTPKvnLElt5NS-Zi78MoaO86mHtkViEs',
	'PMPL_CIS_2022_Spring' => '15mvFpD7MBh5tOY9_9q3tMa_FCb3vRgCPzHx5KJtDalY',
	'PMPL_NA_2022_Spring' => '1irSMgr7u84G9ZyOFvn_jxI9zfQF0anadsIi1ukUOGpY',
	'PMPL_TR_2022_Spring' => '1pLnJSueBsbpNd4xBmV59fRrwmvgGaCmdjLz-V1NuxL4',
	'PMPL_WEU_2022_Spring' => '1NbI1x3YTXOJgWb87merkzDSrhd-v81F-Ag4wubSvJKM',
	
	'PMPL_AF_Q_2022_Spring' => '1cdGS1x9oci2A3e56cRsKF2b-mRSQyRmFLhveimjtoNw',
	'PMPL_AR_Q_2022_Spring' => '13IPeX1i4aiOXpYHFkiWIGi1etCqFSSOF7hwp0sPL4Lk',
	'PMPL_CIS_Q_2022_Spring' => '1eIDcFIyDlkLDgtrx-an80zndu2CsiOWBcHs0sBe9xnw',
	'PMPL_NA_Q_2022_Spring' => '1FgacSHAeO0IYuxrU1ABpNXshqwzYUAT9hz6ZfdnzDMU',
	'PMPL_TR_Q_2022_Spring' => '1Bi1VRbk5jsm_335IpSGvUa4ble6GXHafrV3cf69Xb_k',
	'PMPL_WEU_Q_2022_Spring' => '1bcX2E27sc2cyyPsJohWbyn5B-8WWj-dNuc_65CX5KNI',
	
	'AMCS_2021' => '1N58hxZT794jS9rGrEOnjQNxLIsaLLWyH6QC0psO9vxw',
	'EUCS_2021' => '18i_r9aKnhApKP1mHjSqpjywx2qHH5EfeLkSNP6CoPKs',
	
	'PMCO_CIS' => '1BMHQx0b6b5T8H5u3a20iKhFFwwDatcCK34FrRGo9Q7g',
	'PMCO_ME' => '1YkmVfUsxgIru48lKdyKwDAb5DOIGE0H3ChGZQWv62LA',
	'PMCO_UAE' => '1aPfhu9OiUwoiOd2UBHe1F7miyijG4wmSk5ZY6Rxt5_k',
	'PMCO_TR' => '18GI2jc2IjXNKn4H-6pGNtbZHKY4NWPE4X5wiCk8xpCg',
	'PMCO_IQ' => '1CsGLJNlG2_fjSE_YILPjvVTkGSHwTB0xNneejXeQhtU',
	'PMCO_SA' => '1Ry3NZ29m1CkF4C8rWGpuY-oHsxW6g3BwxHqZ1on9B-4',
	'PMCO_EG' => '1CZjTJrR_72Q_q0i9UcHHGn3MFdaZ-V_FfKDBQV0_Gt0',
	'PMCO_NA' => '18b_9vaAricD6SVSyHjn7qjzJzcnq8ujFSrfJy27VSCg',
	'PMCO_EU' => '1PQqqt0w_GwTeMcqn_is0zFIo0-F6Lqzf6WUgZLTb_ZE',
	'PMCO_AF' => '1bct7afo5DMjAJOJ0uFClZtTi0v20Ev9tbkui3kRw7_I',
	'PMCO_DE' => '1i4O7Q69UdRUErBbRu0efKrx2vgitKbtlfJelcPEhPf0',
	'PMCO_FR' => '1uK089Ye00_yv_CegZLmCl2hgS9SsNDJkRymDi85W6uw',
	'PMCO_UK' => '12MYpjqZ8Jb0yTxV5Po5-p-n2kKRx2vx1ORzHRfyWFmw',

	'PMPL_CIS_2021_S2' => '1C7wqW0p0z5VoGFBFNc4RgdfUjGjTV8eqIIRonn10CqA',
	'PMPL_AR_2021_S2' => '1fHeUIUKpCi_JDr7RjXed3yi4XKKzm9crdPou3pXHYsk',
	'PMPL_TR_2021_S2' => '1KVY2QCjn5KrG9kgtWd-bABTayh8uyK8ntOtgbZlGKMM',
	'PMPL_EU_2021_S2' => '1UUjr_TfYt9XqZznmjP7RvZox14dA32upeZGBACrE1ww',
	'PMPL_NA_2021_S2' => '1NqycozDC0w23LtM-bYFu-frBrP0aFVsZ181RbI_w0wY',
	
	'PMPL_CIS_2021_S1' => '1O8ZrEUzezlitoCV6yEgrmIWNeGU2nD-uJaaaOeJRY08',
	'PMPL_AR_2021_S1' => '1TeIKF35bwbSW8IW4KBhMb7fyTxevq0UmkO0_a_2HhOY',
	'PMPL_TR_2021_S1' => '1SG2yw3AzLRTI1y8nO2dkUCvvo0ifcKslcK1dG92QGww',
	'PMPL_NA_2021_S1' => '16Vmd_yZ9EoPI4I32xhARVOVjiPRwsLl4-Al7_56t1xU',
	'PMPL_EU_2021_S1' => '17t-rl8ca4qfGZG9byXfmSBbkIWJednVUxImVzNcNCb8',

	'EMEA_S1' => '1giETQzQCvbgK3Zoxrv--t8Wy67bfaawcH_RZiI3PJz4'
];

$links = [
	
	'bvZ98NGAmB74uEUPcQr2dJsaMLDH63fe' => ['r' => 'PMWC_2024', 't' => $PMWCday8],
	
	// PMPL Quali All Days
	'sJ8aU9rPT5vGCZVXhjeDSfY26BLNmWkH' => ['r' => 'PMPL_CIS_Q_2022_Spring', 't' => $PMCOday3],
	'EyrXJkHtWubwhMGUfZL5ezsmQqj92N4K' => ['r' => 'PMPL_WEU_Q_2022_Spring', 't' => $PMCOday3],
	'nEXg9CWrYuK5qy8sfGMHA2bkdJLjzUFR' => ['r' => 'PMPL_AR_Q_2022_Spring', 't' => $PMCOday3],
	'CdhtEbxF3GBenAyrR2D8f5u6LUqK7QZT' => ['r' => 'PMPL_TR_Q_2022_Spring', 't' => $PMCOday3],
	'EBfj8Q7F5AWYRDUcysKbZpdhJkM3C42u' => ['r' => 'PMPL_NA_Q_2022_Spring', 't' => $PMCOday3],
	
	'vrVBWRxZKD8GcnCzH7begwTXmJtqdj4S' => ['r' => 'PMPL_AF_Q_2022_Spring', 't' => $PMCOdayPlayins],
	
	'KbgVwN2ACWvayBdkezGDL47f3SqhMpP5' => ['r' => 'PMPL_AR_2022_Spring', 't' => $PMPLday18],
	'zKQdUPJLjF2R5ZwE7MbhyatvgB4r9C3x' => ['r' => 'PMPL_CIS_2022_Spring', 't' => $PMPLday18],
	'TrkJqfLRN6x7bw92dZFjeDgamhpzsyHM' => ['r' => 'PMPL_WEU_2022_Spring', 't' => $PMPLday18],
	'Ua2J9PZxL3F4dbHnDv6ugAf5t8QhMYVp' => ['r' => 'PMPL_AF_2022_Spring', 't' => $PMPLday18],
	'Bt7mPCXsdyYQK4L5Evn2TSkxURzMpF63' => ['r' => 'PMPL_TR_2022_Spring', 't' => $PMPLday18],
	'FLXRWfKjxdEuVhD9nJCcB4myYg6wQP3a' => ['r' => 'PMPL_NA_2022_Spring', 't' => $PMPLday18],
	
	'a6HmBjpKRJX4PCE2fsVFQrtGvnD7Txgu' => ['r' => 'PMPL_CS_2022_EU', 't' => $PMCOday4],
	'u7q6W9BTn2pCMbr5XKzsa4yxjQHZgU8L' => ['r' => 'PMPL_CS_2022_MEA', 't' => $PMCOday4],
	'NPtwyA39zq6WF4VHfxRvBXSkueM5b8pY' => ['r' => 'PMPL_CS_2022_AM', 't' => $PMCOday4],
	
	'UMhPgy5psf8Q9Y7AJuWajSkH36mbGvNL' => ['r' => 'PMPL_AR_2022_Fall', 't' => $PMPLday18],
	'MfjAgpCrLFNPz4uJhD9VTSY7c2ymq6dK' => ['r' => 'PMPL_WEU_2022_Fall', 't' => $PMPLnewDay21],
	'DhUTHMfnx28SZrAWQ4aedp6bwK3kjEgN' => ['r' => 'PMPL_AF_2022_Fall', 't' => $PMPLnewDay21],
	'wyh49TaYKDjsESZxc2fLteGNmV5q6Hku' => ['r' => 'PMPL_NA_2022_Fall', 't' => $PMPLnewDay21],
	'F2dL4GYUsVKaTuDZpRhBQP3JxMrtf5Xe' => ['r' => 'PMPL_TR_2022_Fall', 't' => $PMPLnewDay21],
	
	
	'ds2YCfrQ9aHb36EK5AwZc7LgXpD8uhBe' => ['r' => 'PMWI_Week_1', 't' => $PMCOday3],
	'ULH7gXnNe3muMrPCv2xAVkpfBDG6jSER' => ['r' => 'PMWI_Week_2', 't' => $PMCOday3],
	'bwyNCqDSJdr28knHGPUtYhQ5AvcMaE3K' => ['r' => 'PMWI_Week_2_DUO', 't' => ['Showmatch' => 'on']],
	
	'Z86xzXUkthrY5NF9gAeDqGbTuMad47Sf' => ['r' => 'PMPL_CS_2022_MEA_Fall', 't' => $PMCOday4],
	's7Et5kVr43bZQYaeuBzXw6fPF9dUGWpN' => ['r' => 'PMPL_CS_2022_EU_Fall', 't' => $PMCOday4],
	'Bq6SveIdcHXTD65FQC4I6kPDSZTgTS5W' => ['r' => 'PMPL_CS_2022_AM_Fall', 't' => $PMCOday4],
	
	
	'g4uFLmkjYjSpKrGbXkcIh4cRFMN9Kz9h' => ['r' => 'PMPL_EU_2023_Spring', 't' => $PMPLnewDay21],
	'UNd7KmQswneFYsSkLdbQ2HeqjhApV9tP' => ['r' => 'PMPL_AF_2023_Spring', 't' => $PMPLnewDay21],
	'naymMSYm8Hgct48sCsuVugHdtMVrJSQ2' => ['r' => 'PMPL_NA_2023_Spring', 't' => $PMPLnewDay21],
	'5ReERVEazbzeZsQN48PUNmrTGwCfMZKG' => ['r' => 'PMPL_TR_2023_Spring', 't' => $PMPLday18],
	'efPpyDfXfPbpz6n79gfeaVkSBUCpAhtE' => ['r' => 'PMPL_AR_2023_Spring', 't' => $PMPLnewDay21],
	
	'xUEaZaubxcX3ff8mmBYwUBze5YTjdtxk' => ['r' => 'PMPL_CS_2023_AM_Spring', 't' => $PMCOday4],
	'RXd78bbrL5T3T8eLMjC6yvLXFnhNxQ8s' => ['r' => 'PMPL_CS_2023_EU_Spring', 't' => $PMCOday4],
	'fHH77sUrdgDm92hXqhaQNm8eHfypCRn3' => ['r' => 'PMPL_CS_2023_MEA_Spring', 't' => $PMCOday4],
	
	'Wu39KCNye7vShhnH7GFKTnWPfjMHTs9J' => ['r' => 'PMWI_2023_Allstars', 't' => $PMCOday3],
	'h63pHUTrbnQG69YXQmfDTYnF63JjpXm6' => ['r' => 'PMWI_2023_MainTournament', 't' => $PMCOday3],
	
	'WbMMvMLvWU4vTJcFTVjxe3s5VuWbAtq9' => ['r' => 'PMRC_2023_MEACS_EUCS', 't' => $PMCOday4],
	
	'W3uKMB27T2UQu6AhQVaNYCpM8fCMA2A5' => ['r' => 'PMPL_AR_2023_Fall', 't' => $PMPLnewDay21],
	'JkNYDtbxD3mcyU8E8YasVejHXpLkwNRG' => ['r' => 'PMPL_AF_2023_Fall', 't' => $PMPLnewDay21],
	'2W3NkxGuEvU4QSVSgE5juuKkv2hDv5NU' => ['r' => 'PMPL_NA_2023_Fall', 't' => $PMPLnewDay21],
	'W3uKMB27T2UQu6AhQVaNYCpM8fCMA2A5' => ['r' => 'PMPL_AR_2023_Fall', 't' => $PMPLnewDay21],
	'c59aLJz6rWqqr68c9PSuaX45GCEMQLhN' => ['r' => 'PMPL_EU_2023_Fall', 't' => $PMPLnewDay21],
	'7DLy7rZxUWTUpXzAEf9V4gzzxzkWU5Sq' => ['r' => 'PMPL_TR_2023_Fall', 't' => $PMPLday18],
	
	'ktcDdYJSCGdyYJhq9WUhnX7xeF2LWMYC' => ['r' => 'PMPL_CS_2023_AM_Fall', 't' => $PMCOday4],
	'xbKEURZszBebSLzzZ8Sdve9tfAQVpsYg' => ['r' => 'PMPL_CS_2023_MEA_Fall', 't' => $PMCOday4],
	'snDSqyhLCWSJ5fS7kSFHdkYUqX3PfQjk' => ['r' => 'PMPL_CS_2023_EU_Fall', 't' => $PMCOday4],
	
	'U5P36dwbp42CjLRmeZTazqDAytB9Q7JW' => ['r' => 'PMSL_2024_EMEA_Spring', 't' => $PMPLnewDay21],
	
	'R5EFv7fgvMPkyAPbPgEB8eatFxZTsEzd' => ['r' => 'PMSL_2024_EU_Spring', 't' => $PMPLnewDay21],
	
	'xgapm2dQrBeMYEvbc6Lpt4pjkXCZKede' => ['r' => 'PMSL_2024_MEA1_Spring', 't' => $PMPLnewDay3],
	'JBNuXaeWk6LFQspMZD9mwPS48HnyjTtd' => ['r' => 'PMSL_2024_MEA2_Spring', 't' => $PMPLnewDay3],
	'Ngbf6KtWse7DF2wmdM9GxB5CZJ3kn4qh' => ['r' => 'PMSL_2024_MEAF_Spring', 't' => $PMPLnewDay21],
	
	'r5RaJQv7fBgwP8ZTL9S4u3jnACkKmtWq' => ['r' => 'PMSL_2024_EU_Fall', 't' => $PMCOday4],
	
	'' => ['r' => '', 't' => []]
];


// EMEA Spring
if ($dateNow > new DateTime('2024-09-18 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay1]; }
if ($dateNow > new DateTime('2024-09-19 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay2]; }
if ($dateNow > new DateTime('2024-09-20 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay3]; }
if ($dateNow > new DateTime('2024-09-21 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay4]; }
if ($dateNow > new DateTime('2024-09-22 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay5]; }
if ($dateNow > new DateTime('2024-09-25 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay7]; }
if ($dateNow > new DateTime('2024-09-26 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay8]; }
if ($dateNow > new DateTime('2024-09-27 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay9]; }
if ($dateNow > new DateTime('2024-09-28 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay10]; }
if ($dateNow > new DateTime('2024-09-29 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay11]; }
if ($dateNow > new DateTime('2024-10-02 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay13]; }
if ($dateNow > new DateTime('2024-10-03 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay14]; }
if ($dateNow > new DateTime('2024-10-04 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay15]; }
if ($dateNow > new DateTime('2024-10-05 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay16]; }
if ($dateNow > new DateTime('2024-10-06 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay17]; }
if ($dateNow > new DateTime('2024-10-11 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay19]; }
if ($dateNow > new DateTime('2024-10-12 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay20]; }
if ($dateNow > new DateTime('2024-10-13 22:15')) { $links['YFJAuWeLj8nEyw4fKv9Tz3aqhkmPDH6X'] = ['r' => 'PMSL_2024_EMEA_Fall', 't' => $PMPLnewDay21]; }


$CACHE_TIME = 60*30;
$CACHE_TIME_TABS = 60*60*24*7;


/*









bhVkgDsaSqf5v2yxArERtQKPuTwL4UnN
p6qUjfVm2k9xR7vXyJr5NZzHsDLAGWFE
yLG2CnQjfSzWcgV9r8hbqPNBUw64DKAX
sB7trcNmLwA48KeGaRZhzMfHFEDqg2V3
wBDqGdRhU8eQEnHMvLfjru2ZsCN4cg7V

qxLVzkTjpdr6ZmXw38hnguHWaKfsPtDB
VdTkyEmSGZ6BXwM9Uan4phbPLsc7J2vq
y7qWx4JMs5F8vgXGNe2tEDApbVckmdHB
dQpZcK74wUjACEeMg6hnV2XxRLTqFH3t
YptHCkzqydcbXJ2URvTSZaFBhN5WfGAx
PLzJnsqyhCwe4vEQXZjSGf6N5MFrbdp7
jP4mEJFRUScKfqwnh6XDCTHyeAWQupxr
bZ7FdV3QYwUxWCuetr4cqgAaPTMyD68G
C6kzu5P2mq8Z4FjrBESpJgNyMXW3AVhD

*/
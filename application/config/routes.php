<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'LoginController';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['GOLogin']='LoginController/go_login';


////////// BRANCH//////////
$route['ViewSubsidiary']='BranchController';
$route["fetchBranch"]="BranchController/getCompanyTableData";
$route["getBranchData"]="BranchController/getBranchData";
$route["CreateUpdateBranch"]="BranchController/CreateUpdateBranch";
$route["getDataBranchByID"]="BranchController/getDataBranchByID";
$route["getCountryList"]="BranchController/getCountryList";
$route["SpecialSubsidiaryMapping"]="BranchController/SpecialSubsidiaryMapping";
$route["getSpecialSubsidiaries"]="BranchController/getSpecialSubsidiaries";
$route["getParentGlAccounts"]="BranchController/getParentGlAccounts";
$route["SaveMapping"]="BranchController/SaveMapping";

//////////CompanyBranch/////////////////////////////
$route['companybranch']='BranchController/companybranch';

////////////////////COMPANY/////////////////////////////
$route['view_companies']='CompanyController/view_companies';

$route['getCompanyData'] = 'CompanyController/getCompanyData';
$route['CreateUpdateCompany'] = 'CompanyController/CreateUpdateCompany';
$route['getDataCompanyByID'] = 'CompanyController/getDataCompanyByID';
$route['getLisCompany'] = 'CompanyController/getLisCompany';



$route['handson']='HandsonController/handson';
$route['ExportToTable']='HandsonController/ExportToTable';
$route['ExportToTable2']='HandsonController/ExportToTable2';
$route['getExportToTableData']='HandsonController/getExportToTableData';
$route['getIntraCompanyTransfer'] = 'HandsonController/getIntraCompanyTransfer';
$route['getFinancialData_upload'] = 'HandsonController/getFinancialData';
$route['getFinancialData_list'] = 'HandsonController/getFinancialData_list';
$route['getCompanyBranchList'] = 'HandsonController/getCompanyBranchList';
$route['saveCopyFiancialData']='HandsonController/saveCopyFiancialData';
$route['saveCopyIntraData']='HandsonController/saveCopyIntraData';
$route['viewIntraCompanyDetails/(:any)']='HandsonController/viewIntraCompanyDetailsHandson/$1';
// $route['viewIntraCompanyDetailsHandson/(:any)']='HandsonController/viewIntraCompanyDetailsHandson/$1';
$route['getBranchGlAccount']='HandsonController/getBranchGlAccount';
$route['getCompanyGlAccount']='HandsonController/getCompanyGlAccount';
$route['uploadIntraTransaction']='HandsonController/uploadIntraTransaction';
$route['getIntraInfoById']='HandsonController/getIntraInfoById';
$route['getIntraTransactionTable']='HandsonController/getIntraTransactionTable';
$route['deleteIntraTrasaction']='HandsonController/deleteIntraTrasaction';
$route['approveIntraStatus']='HandsonController/approveIntraStatus';
$route['getIntraTableData']='HandsonController/getIntraTableData';
$route['getdefaultGlAccount']='HandsonController/getdefaultGlAccount';
$route['ClearEntityTransfer']='HandsonController/ClearEntityTransfer';


$route['saveCopyFiancialDataPrevious']='HandsonController/saveCopyFiancialDataPrevious';


//////////////TEMPLATE///////////////////////////////
$route['template'] = 'Template/index';
$route['getTablesList'] = 'Template/getTablesList';
$route['addtemplate'] = 'Template/addTemplate';
$route['edittemplate'] = 'Template/editTemplate';
$route['updatetemplate'] = 'Template/updateTemplate';
$route['getTemplates'] = 'HandsonController/getTemplates';
$route['getMatchUnMatchData'] = 'HandsonController/getMatchUnMatchData';
$route['assigntemplate'] = 'Template/assignTemplate';
$route['getTemplateCompanyData'] = 'Template/getCompanyData';
$route['getTemplateBranchData'] = 'Template/getBranchData';
$route['getTemplateData'] = 'Template/getTemplateData';
$route['assignTemplateToBranch'] = 'Template/assignTemplateToBranch';
$route['getTemplateBranchAssignList'] = 'Template/getTemplateBranchAssignList';
$route['downloadMatchedData/(:any)'] = 'HandsonController/downloadMatchedData/$1';

$route['getMatchUnMatchDataUs'] = 'HandsonController/getMatchUnMatchDataUs';
$route['getMatchUnMatchDataIfrs'] = 'HandsonController/getMatchUnMatchDataIfrs';


/////////HANDSON//////////
$route['handson']='HandsonController/handson';
$route['uploadIntraCompanyTransfer']='HandsonController/uploadIntraCompanyTransfer';




//////////Main Account Setup//////////
$route['MainSetup'] = 'MainAccountSetup/index';
$route['getMainSetupData'] = 'MainAccountSetup/getMainSetupData';
$route['getMainSetupbyId'] = 'MainAccountSetup/getMainSetupbyId';
$route['CreateUpdateMainSetup'] = 'MainAccountSetup/CreateUpdateMainSetup';
$route['getIndGroupData'] = 'MainAccountSetup/getIndGroupData';
$route['getIndiaGroupData'] = 'MainAccountSetup/getIndiaGroupData';
$route['InsertIndGroupData'] = 'MainAccountSetup/InsertIndGroupData';
$route['CheckIndGroup'] = 'MainAccountSetup/CheckIndGroup';
$route['UpdateIndGroup'] = 'MainAccountSetup/UpdateIndGroup';

$route['getUSGroupingData'] = 'MainAccountSetup/getUSGroupingData';
$route['getUSGroupData'] = 'MainAccountSetup/getUSGroupData';
$route['InsertUSGroupData'] = 'MainAccountSetup/InsertUSGroupData';
$route['CheckUSGroup'] = 'MainAccountSetup/CheckUSGroup';
$route['UpdateUSGroup'] = 'MainAccountSetup/UpdateUSGroup';

$route['getIfrsGroupingData'] = 'MainAccountSetup/getIfrsGroupingData';
$route['getIfrsGroupData'] = 'MainAccountSetup/getIfrsGroupData';
$route['InsertIfrsGroupData'] = 'MainAccountSetup/InsertIfrsGroupData';
$route['CheckIfrsGroup'] = 'MainAccountSetup/CheckIfrsGroup';
$route['UpdateIfrsGroup'] = 'MainAccountSetup/UpdateIfrsGroup';

$route['RemoveGroupData'] = 'MainAccountSetup/RemoveGroupData';

//////////Branch Account Setup//////////
$route['SubsidiarySetup'] = 'BranchAccountSetup/index';
$route['Excel'] = 'BranchAccountSetup/excel';
$route['InsertDataBranchSetup'] = 'BranchAccountSetup/InsertDataBranchSetup';
$route['InsertUSBranchSetup'] = 'BranchAccountSetup/InsertUSBranchSetup';
$route['InsertIFRSBranchSetup'] = 'BranchAccountSetup/InsertIFRSBranchSetup';
$route['Mapping']='BranchAccountSetup/DragDrop';
$route['UpdateParentBranch']='BranchAccountSetup/UpdateParentBranch';
$route['getParentMappingData']='BranchAccountSetup/getParentMappingData';
$route['branch_excelupload']='BranchAccountSetup/branch_excelupload';
$route['getPercentageHoldingData']='BranchAccountSetup/getPercentageHoldingData';
$route['InsertPercentageHoldData']='BranchAccountSetup/InsertPercentageHoldData';
$route['clearPercentageHoldData']='BranchAccountSetup/clearPercentageHoldData';


////////////////////UPLOAD DATA////////////////////////
$route['upload_data'] = 'UploadDataController/index';
$route['user_excel_view'] = 'UploadDataController/user_excel_view';
$route['getUserViewData'] = 'UploadDataController/getUserViewData';
$route['SaveData'] = 'UploadDataController/SaveData';
$route['approveData'] = 'UploadDataController/approveData';

////////////////////VIEW HISTORY ////////////////////////
$route['view_history'] = 'ViewHistoryController/index';
$route['getViewHistory'] = 'ViewHistoryController/getViewHistory';


//////////////////USERS///////////////////////////////
$route['Users'] = 'UserMasterController/index';
$route['getUserData'] = 'UserMasterController/getUserData';
$route['CreateUpdateUsers'] = 'UserMasterController/CreateUpdateUsers';
$route['getBranchList'] = 'UserMasterController/getBranchList';
$route['getDataUserByID'] = 'UserMasterController/getDataUserByID';
$route['getAllPermissions'] = 'UserMasterController/getAllPermissions';
$route['saveUsersPermission'] = 'UserMasterController/saveUsersPermission';
$route['getListBranchUserwise'] = 'UserMasterController/getListBranchUserwise';
$route['getAllPermissionsCompany'] = 'UserMasterController/getAllPermissionsCompany';

//Currency
$route['currency'] = 'CurrencyController/index';
$route['CreateUpdateCurrency'] = 'CurrencyController/CreateUpdateCurrency';
$route['getDataCurrencyByID'] = 'CurrencyController/getDataCurrencyByID';
$route['getCurrencyData'] = 'CurrencyController/getCurrencyData';
$route['getCurrencyCountry'] = 'CurrencyController/getCurrencyCountry';
$route['getCurrencyDataH'] = 'CurrencyController/getCurrencyDataH';
$route['saveCurrencyConversion'] = 'CurrencyController/saveCurrencyConversion';
$route['getCurrencyDataDT'] = 'CurrencyController/getCurrencyDataDT';
$route['viewCurrencyDetails/(:num)'] = 'CurrencyController/viewCurrencyDetails/$1';
$route['getCurrencyDataHCC'] = 'CurrencyController/getCurrencyDataHCC';
$route['saveHOSData'] = 'CurrencyController/saveHOSData';



$route['getDataMain'] = 'MainAccountSetup/getDataMain';
$route['getUSData'] = 'MainAccountSetup/getUSData';
$route['getIFRSData'] = 'MainAccountSetup/getIFRSData';
$route['getValueDetail'] = 'MainAccountSetup/getValueDetail';
$route['getMainAccountData'] = 'MainAccountSetup/getMainAccountData';
$route['getUSMainAccountData'] = 'MainAccountSetup/getUSMainAccountData';
$route['getIFRSMainAccountData'] = 'MainAccountSetup/getIFRSMainAccountData';
$route['InsertMainAccountData'] = 'MainAccountSetup/InsertMainAccountData';
$route['InsertUSAccountData'] = 'MainAccountSetup/InsertUSAccountData';
$route['InsertIFRSAccountData'] = 'MainAccountSetup/InsertIFRSAccountData';
$route['excelupload'] = 'MainAccountSetup/excelupload';

////////////////////////////// Report ////////////////////
$route['consolidate'] = 'ConsolidateReport/index';
$route['getSumValues'] = 'ConsolidateReport/getSumValues';
$route['saveConsolidationReport'] = 'ConsolidateReport/saveConsolidationReport';
$route['view_consolidate_report'] = 'ConsolidateReport/view_consolidate_report';
$route['getReportList'] = 'ConsolidateReport/getReportList';
$route['update_report'] = 'ConsolidateReport/update_report';
$route['getUpdateReportData'] = 'ConsolidateReport/getUpdateReportData';
$route['getTotalData'] = 'ConsolidateReport/getTotalData';
$route['getUpdatedData'] = 'ConsolidateReport/getUpdatedData';
$route['BalanceSheet'] = 'ConsolidateReport/view_bs';
$route['PL'] = 'ConsolidateReport/view_pl';
$route['getTotalDataDB'] = 'MainAccountSetup/getTotalDataDB';
$route['update_report_schedule'] = 'ConsolidateReport/update_report_schedule';
$route['getScheduleReportData']='ConsolidateReport/getScheduleReportData';
$route['getScheduleReportDataWithSequence']='ConsolidateReport/getScheduleReportDataWithSequence';
$route['scheduleView']='ConsolidateReport/scheduleView';
$route['BalanceSheetData']='ConsolidateReport/create_balanceSheet';
$route['PLData']='ConsolidateReport/createpl';
$route['previousConsolidate']='ConsolidateReport/previousConsolidate';
$route['RunFinalConsolidation']='ConsolidateReport/RunFinalConsolidation';
$route['getFinalTotalDataDB']='ConsolidateReport/getFinalTotalDataDB';



$route['getCountryCurrencyData']='CurrencyController/getCountryCurrencyData';

////////////////////////// block year /////////////////////////////
$route['block_year']='BlockYearController/block_year';
$route['blockFormRowUpload']='BlockYearController/blockFormRowUpload';
$route['getBlockYearList']='BlockYearController/getBlockYearList';
$route['activeInactiveStatus']='BlockYearController/activeInactiveStatus';
$route['getNoBlockMonth']='BlockYearController/getNoBlockMonth';
$route['defaultFormRowUpload']='BlockYearController/defaultFormRowUpload';
$route['getDefaultYearList']='BlockYearController/getDefaultYearList';
$route['activeInactiveStatusDefaultYear']='BlockYearController/activeInactiveStatusDefaultYear';
$route['getDefaultYearMonthDetails']='BlockYearController/getDefaultYearMonthDetails';

////////////////////////// excel upload ////////////////////////////////
$route['excelUploadValidation']='HandsonController/excelUploadValidation';
$route['ExportToTableValidation']='HandsonController/ExportToTableValidation';
$route['saveExcelColumns']='ExcelUploadController/SaveExcel';
$route['saveMainExcelColumns']='ExcelUploadController/SaveMainExcel';
$route['SaveBranchExcel']='ExcelUploadController/SaveBranchExcel';
$route['ExportToTableValidationConsolidate']='HandsonController/ExportToTableValidationConsolidate';
$route['saveExcelColumnsConsolidate']='ExcelUploadController/SaveExcelConsolidate';
$route['ClearAllFinancialData']='ExcelUploadController/ClearAllFinancialData';



////////////////////////// Report Builder ////////////////////////////////
// $route['reportMaker']='ReportMakerController/index';
$route['reportMaker/(:num)']='ReportMakerController/index/$1';
$route['reportMakerList']='ReportMakerController/reportMakerList';
$route['GetReportView']='ReportMakerController/GetReportView';
$route['reportMakerByMonth']='ReportMakerController/reportMakerByMonth';
$route['createReportMonthPdf']='ReportMakerController/createReportMonthPdf';
$route['getReportTemplateData']='ReportMakerController/getReportTemplateData';
$route['getGlAccountData']='ReportMakerController/getGlAccountOptions';
$route['uploadTemplateData']='ReportMakerController/uploadTemplateData';
$route['createWordFile']='ReportMakerController/createWordFile';
$route['addWordFileHtml']='ReportMakerController/addWordFileHtml';
$route['getGroupYearData']='ReportMakerController/getGroupYearData';
$route['getGroupYearData2']='ReportMakerController/getGroupYearData2';
$route['getGroupYearData1']='ReportMakerController/getGroupYearData1';
$route['getConsolidatedMonth']='ReportMakerController/getConsolidatedMonth';
$route['getDerivedGLData'] = 'ReportMakerController/getDerivedGLData';

$route['getErrors'] = 'ConsolidateReport/getErrors';
$route['RemoveSubsidiaryData'] = 'BranchAccountSetup/RemoveSubsidiaryData';
$route['MainMapping'] = 'MainAccountSetup/MainMapping';
$route['getMainMapData'] = 'MainAccountSetup/getMainMapData';
$route['UpdateMainGroupMap'] = 'MainAccountSetup/UpdateMainGroupMap';
$route['clearData'] = 'BranchAccountSetup/ClearData';

//Template Tool
$route['templateTool'] = 'TemplateToolController';
$route['addHandsonTemplate']='TemplateToolController/addHandsonTemplate';
$route['copyHandsonTemplate']='TemplateToolController/copyHandsonTemplate';
$route['getTablesList'] = 'TemplateToolController/getTablesList';
$route['edithandsontemplate'] = 'TemplateToolController/edithandsontemplate';
$route['changeHandsonTemplateStatus'] = 'TemplateToolController/changeHandsonTemplateStatus';
$route['fetch_all_created_templatetool'] = 'TemplateToolController/fetchAllCreatedTemplatesTool';
$route['fetch_templatesTool'] = 'TemplateToolController/fetch_templatesTool';
$route['fetch_templatesHandonData'] = 'TemplateToolController/fetch_templatesHandonData';
$route['saveSpreadSheetTool'] = 'TemplateToolController/saveSpreadSheetTool';
$route['fetch_templatesToolHandsonData'] = 'TemplateToolController/fetch_templatesToolHandsonData';
$route['savePrefillTemplateTool'] = 'TemplateToolController/savePrefillTemplateTool';
$route['SaveSpreadSheetAssignment'] = 'TemplateToolController/SaveSpreadSheetAssignment';
$route['getTemplateListAssignData'] = 'TemplateToolController/getTemplateListAssignData';
$route['getListsheet'] = 'TemplateToolController/getListsheet';
$route['CompanySpreadsheet'] = 'TemplateToolController/CompanySpreadsheet';
$route['getGlAccountList'] = 'TemplateToolController/getGlAccountList';
$route['getTablesList1'] = 'TemplateToolController/getTablesList1';
$route['ClearTemplateData'] = 'TemplateToolController/ClearTemplateData';
$route['ClearTemplateTransactionData'] = 'TemplateToolController/ClearTemplateTransactionData';
$route['DownloadAllScheduleForSubisdiary'] = 'TemplateToolController/DownloadAllScheduleForBranch';
$route['getTableDatafromHashKey'] = 'TemplateToolController/getTableDatafromHashKey';
$route['getCurrencyData'] = 'TemplateToolController/getCurrencyData';
$route['saveCurrencyConversion1'] = 'TemplateToolController/saveCurrencyConversion';
$route['getRupeesData'] = 'TemplateToolController/getRupeesData';
$route['saveRupeesData'] = 'TemplateToolController/saveRupeesData';
$route['getGlAccountMappingData'] = 'TemplateToolController/getGlAccountMappingData';
$route['saveGlMappData'] = 'TemplateToolController/saveGlMappData';
$route['DownloadAllRupeesScheduleForSubsidiary'] = 'TemplateToolController/DownloadAllRupeesScheduleForBranch';
$route['downlodAllbranchExcel'] = 'TemplateToolController/DownloadAllScheduleForBranchEXCL';
$route['downlodAllbranchRupeesExcel'] = 'TemplateToolController/DownloadAllRupeesScheduleForBranchEXCl';

////////////////////////// Report Builder Version 2 ////////////////////////////////

$route['tableReportMakerList']='TableReportMakerController/tableReportMakerList';
$route['GetTableReportView']='TableReportMakerController/GetReportView';
$route['tableReportMaker/(:num)']='TableReportMakerController/index/$1';
$route['getTableReportTemplateData']='TableReportMakerController/getTableReportTemplateData';
$route['uploadTableTemplateData']='TableReportMakerController/uploadTableTemplateData';
$route['tablereportMakerByMonth']='TableReportMakerController/reportMakerByMonth';
$route['createTableReportMonthHandson']='TableReportMakerController/createTableReportMonthHandson';
$route['getTableConsolidatedMonth']='TableReportMakerController/getConsolidatedMonth';


//////// report version 3 ///////////////
$route['version3Report']='ReportVersion3Controller/version3Report';
$route['version3ReportMaker']='ReportVersion3Controller/version3reportMaker';
$route['tableReportVersion3MakerList']='ReportVersion3Controller/tableReportMakerList';
$route['GetTableReportVersion3View']='ReportVersion3Controller/GetReportView';
$route['tableReportMakerVarsion3/(:num)']='ReportVersion3Controller/index/$1';
$route['getTableReportVersion3TemplateData']='ReportVersion3Controller/getTableReportTemplateData';
$route['uploadTableTemplateVersion3Data']='ReportVersion3Controller/uploadTableTemplateData';
$route['reportMakerByMonthVersion3']='ReportVersion3Controller/reportMakerByMonth';
$route['getTableConsolidatedMonthVersion3']='ReportVersion3Controller/getConsolidatedMonth';
$route['createTableReportMonthHandsonVersion3']='ReportVersion3Controller/createTableReportMonthHandson';
$route['getAllBranchesDownload']='ReportVersion3Controller/createExcel';

$route['getCurrencyAverageValue']='HandsonController/getCurrencyAverageValue';
$route['getReportTemplateList']='ReportVersion3Controller/getReportTemplateList';
$route['changeStatusOfReport']='ReportVersion3Controller/changeStatusOfReport';

$route['getTableDatafromHashKey1'] = 'TemplateToolController/getTableDatafromHashKey1';
$route['downloadTableDatafromHashKey1'] = 'TemplateToolController/downloadTableDatafromHashKey1';



//////// DataAnalytics //////
$route['DataAnalytics']='DataAnalyticsController/DataAnalytics';
$route['getDataAnalyticsData']='DataAnalyticsController/getDataAnalyticsData';
$route['showDataAnalyticsTransaction']='DataAnalyticsController/showDataAnalyticsTransaction';
$route['TransferDataTableTransaction']='DataAnalyticsController/TransferDataTableTransaction';
$route['showDataAnalyticsTransferTransaction']='DataAnalyticsController/showDataAnalyticsTransferTransaction';
$route['getscheduleTrnsactions']='DataAnalyticsController/getscheduleTrnsactions';


//Spc Exchange Rate 13/10/2022
$route['specialExchangeRate'] = 'CurrencyController/spc_exchangeRate';
$route['getGlDataByBranchID'] = 'CurrencyController/getGlDataByBranchID';
$route['saveGlDataByBranchID'] = 'CurrencyController/saveGlDataByBranchID';
$route['getExchangeRateDateList'] = 'CurrencyController/getExchangeRateDateList';
$route['delexchangeRate'] = 'CurrencyController/delexchangeRate';
$route['getSubsidiaryData'] = 'CurrencyController/getSubsidiaryData';


// spc addition rate 9/11/2022
$route['saveAdditionGlDataByBranchID']='CurrencyController/saveAdditionGlDataByBranchID';
$route['getAdditionGLRateTable']='CurrencyController/getAdditionGLRateTable';
$route['deleteAdditionGLRate']='CurrencyController/deleteAdditionGLRate';



// Main account schedule setup ..
$route['getMainScheduleAccountData']='MainAccountSetup/getMainScheduleAccountData';
$route['getIndSchedulingData']='MainAccountSetup/getIndSchedulingData';
$route['InsertMainScheduleAccountData']='MainAccountSetup/InsertMainScheduleAccountData';
$route['getParentSchedulingAccount']='MainAccountSetup/getParentSchedulingAccount';
$route['getScheduleDataSet']='MainAccountSetup/getScheduleDataSet';
$route['getSubsidiaryAccountMappingData']='TemplateToolController/getSubsidiaryAccountMappingData';
$route['saveSubMappData']='TemplateToolController/saveSubMappData';
$route['getScheduleCompany']='TemplateToolController/getScheduleCompany';
$route['clearScheduleSubsidiaryMapp']='TemplateToolController/clearScheduleSubsidiaryMapp';

// Auditor After Adjustment
$route['saveAuditorGlDataByBranchID']='CurrencyController/saveAuditorGlDataByBranchID';
$route['getAuditorGLRateTable']='CurrencyController/getAuditorGLRateTable';
$route['deleteAuditorAdjustmnetGLRate']='CurrencyController/deleteAuditorAdjustmnetGLRate';

// Derived Account Setup
$route['derivedAccountSetup']='DerivedAccountSetupController/index';
$route['uploadDerivedSetup']='DerivedAccountSetupController/uploadDerivedSetup';
$route['getDerivedGlList']='DerivedAccountSetupController/getDerivedGlList';
$route['editDerivedGL']='DerivedAccountSetupController/editDerivedGL';
$route['deleteDerivedGL']='DerivedAccountSetupController/deleteDerivedGL';
$route['derived_report']='DerivedAccountSetupController/derived_report';
$route['getTotalDerivedFormulaReport']='DerivedAccountSetupController/getTotalDerivedFormulaReport';
$route['setDerivedFormulaData']='DerivedAccountSetupController/setDerivedFormulaData';

//schedule download options
$route['getTemplateListOFMonthYear']='TemplateToolController/getTemplateListOFMonthYear';
$route['downlodRupeesConversionAllbranch']='TemplateToolController/downlodRupeesConversionAllbranch';

// Currency Rate Mapping
$route['getCurrencyRateMapping']='TemplateToolController/getCurrencyRateMapping';
$route['saveCurrencyRateMappData']='TemplateToolController/saveCurrencyRateMappData';
$route['clearCurrencyRateMapp']='TemplateToolController/clearCurrencyRateMapp';

$route['ClearTemplateCurrencyRateData']='TemplateToolController/ClearTemplateCurrencyRateData';

//Entity Transfer Changes 26 dec 2022
$route['getEntityTransferDropdownData']='EntityTransferAccountController/getEntityTransferDropdownData';
$route['getTransCompanyGlAccount']='EntityTransferAccountController/getTransCompanyGlAccount';
$route['uploadIntraTransactionData']='EntityTransferAccountController/uploadIntraTransactionData';
$route['getTransCurrencyAverageValue']='EntityTransferAccountController/getTransCurrencyAverageValue';
$route['getTransTableData']='EntityTransferAccountController/getTransTableData';
$route['editTransData']='EntityTransferAccountController/editTransData';
$route['deleteTransdata']='EntityTransferAccountController/deleteTransdata';
$route['getExcelFormat']='EntityTransferAccountController/getExcelFormat';


$route['getTemplateListDropdown']='TemplateToolController/getTemplateListDropdown';
$route['getscheduleTrnsactionsTemplateId']='TemplateToolController/getscheduleTrnsactionsTemplateId';

//Upload Files
$route['uploadAllFiles']='ExcelUploadController/uploadAllFiles';
$route['getAllUploadedFiles']='ExcelUploadController/getAllUploadedFiles';
$route["downloadFile"]="AwsController/downloadFile";
$route["ExportToTableDirectValidation"]="ExcelUploadController/ExportToTableDirectValidation";
$route["uploadOtherFiles"]="ExcelUploadController/uploadOtherFiles";

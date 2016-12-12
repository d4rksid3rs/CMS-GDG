<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "configinfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$config_list = new cconfig_list();
$Page =& $config_list;

// Page init
$config_list->Page_Init();

// Page main
$config_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($config->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var config_list = new ew_Page("config_list");

// page properties
config_list.PageID = "list"; // page ID
config_list.FormID = "fconfiglist"; // form ID
var EW_PAGE_ID = config_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
config_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
config_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
config_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($config->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$config_list->lTotalRecs = $config->SelectRecordCount();
	} else {
		if ($rs = $config_list->LoadRecordset())
			$config_list->lTotalRecs = $rs->RecordCount();
	}
	$config_list->lStartRec = 1;
	if ($config_list->lDisplayRecs <= 0 || ($config->Export <> "" && $config->ExportAll)) // Display all records
		$config_list->lDisplayRecs = $config_list->lTotalRecs;
	if (!($config->Export <> "" && $config->ExportAll))
		$config_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $config_list->LoadRecordset($config_list->lStartRec-1, $config_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $config->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($config->Export == "" && $config->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(config_list);" style="text-decoration: none;"><img id="config_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="config_list_SearchPanel">
<form name="fconfiglistsrch" id="fconfiglistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="config">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($config->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $config_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($config->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($config->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($config->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$config_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fconfiglist" id="fconfiglist" class="ewForm" action="" method="post">
<div id="gmp_config" class="ewGridMiddlePanel">
<?php if ($config_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $config->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$config_list->RenderListOptions();

// Render list options (header, left)
$config_list->ListOptions->Render("header", "left");
?>
<?php if ($config->key->Visible) { // key ?>
	<?php if ($config->SortUrl($config->key) == "") { ?>
		<td><?php echo $config->key->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $config->SortUrl($config->key) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $config->key->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($config->key->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($config->key->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($config->value->Visible) { // value ?>
	<?php if ($config->SortUrl($config->value) == "") { ?>
		<td><?php echo $config->value->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $config->SortUrl($config->value) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $config->value->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($config->value->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($config->value->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$config_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($config->ExportAll && $config->Export <> "") {
	$config_list->lStopRec = $config_list->lTotalRecs;
} else {
	$config_list->lStopRec = $config_list->lStartRec + $config_list->lDisplayRecs - 1; // Set the last record to display
}
$config_list->lRecCount = $config_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $config_list->lStartRec > 1)
		$rs->Move($config_list->lStartRec - 1);
}

// Initialize aggregate
$config->RowType = EW_ROWTYPE_AGGREGATEINIT;
$config_list->RenderRow();
$config_list->lRowCnt = 0;
while (($config->CurrentAction == "gridadd" || !$rs->EOF) &&
	$config_list->lRecCount < $config_list->lStopRec) {
	$config_list->lRecCount++;
	if (intval($config_list->lRecCount) >= intval($config_list->lStartRec)) {
		$config_list->lRowCnt++;

	// Init row class and style
	$config->CssClass = "";
	$config->CssStyle = "";
	$config->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($config->CurrentAction == "gridadd") {
		$config_list->LoadDefaultValues(); // Load default values
	} else {
		$config_list->LoadRowValues($rs); // Load row values
	}
	$config->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$config_list->RenderRow();

	// Render list options
	$config_list->RenderListOptions();
?>
	<tr<?php echo $config->RowAttributes() ?>>
<?php

// Render list options (body, left)
$config_list->ListOptions->Render("body", "left");
?>
	<?php if ($config->key->Visible) { // key ?>
		<td<?php echo $config->key->CellAttributes() ?>>
<div<?php echo $config->key->ViewAttributes() ?>><?php echo $config->key->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($config->value->Visible) { // value ?>
		<td<?php echo $config->value->CellAttributes() ?>>
<div<?php echo $config->value->ViewAttributes() ?>><?php echo $config->value->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$config_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($config->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($config->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($config->CurrentAction <> "gridadd" && $config->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($config_list->Pager)) $config_list->Pager = new cPrevNextPager($config_list->lStartRec, $config_list->lDisplayRecs, $config_list->lTotalRecs) ?>
<?php if ($config_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($config_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $config_list->PageUrl() ?>start=<?php echo $config_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($config_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $config_list->PageUrl() ?>start=<?php echo $config_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $config_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($config_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $config_list->PageUrl() ?>start=<?php echo $config_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($config_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $config_list->PageUrl() ?>start=<?php echo $config_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $config_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $config_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $config_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $config_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($config_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($config_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($config->Export == "" && $config->CurrentAction == "") { ?>
<?php } ?>
<?php if ($config->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$config_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cconfig_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'config';

	// Page object name
	var $PageObjName = 'config_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $config;
		if ($config->UseTokenInUrl) $PageUrl .= "t=" . $config->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $config;
		if ($config->UseTokenInUrl) {
			if ($objForm)
				return ($config->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($config->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cconfig_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (config)
		$GLOBALS["config"] = new cconfig();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["config"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "configdelete.php";
		$this->MultiUpdateUrl = "configupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'config', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $config;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$config->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$config->Export = $_POST["exporttype"];
		} else {
			$config->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $config->Export; // Get export parameter, used in header
		$gsExportFile = $config->TableVar; // Get export file, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $config;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$config->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($config->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $config->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$config->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$config->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$config->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $config->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$config->setSessionWhere($sFilter);
		$config->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $config;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $config->key, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $config->value, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $config;
		$sSearchStr = "";
		$sSearchKeyword = $config->BasicSearchKeyword;
		$sSearchType = $config->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$config->setSessionBasicSearchKeyword($sSearchKeyword);
			$config->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $config;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$config->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $config;
		$config->setSessionBasicSearchKeyword("");
		$config->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $config;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$config->BasicSearchKeyword = $config->getSessionBasicSearchKeyword();
			$config->BasicSearchType = $config->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $config;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$config->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$config->CurrentOrderType = @$_GET["ordertype"];
			$config->UpdateSort($config->key); // key
			$config->UpdateSort($config->value); // value
			$config->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $config;
		$sOrderBy = $config->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($config->SqlOrderBy() <> "") {
				$sOrderBy = $config->SqlOrderBy();
				$config->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $config;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$config->setSessionOrderBy($sOrderBy);
				$config->key->setSort("");
				$config->value->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$config->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $config;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($config->Export <> "" ||
			$config->CurrentAction == "gridadd" ||
			$config->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $config;
		$this->ListOptions->LoadDefault();
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $config;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $config;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$config->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$config->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $config->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$config->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$config->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$config->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $config;
		$config->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$config->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $config;

		// Call Recordset Selecting event
		$config->Recordset_Selecting($config->CurrentFilter);

		// Load List page SQL
		$sSql = $config->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$config->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $config;
		$sFilter = $config->KeyFilter();

		// Call Row Selecting event
		$config->Row_Selecting($sFilter);

		// Load SQL based on filter
		$config->CurrentFilter = $sFilter;
		$sSql = $config->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$config->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $config;
		$config->key->setDbValue($rs->fields('key'));
		$config->value->setDbValue($rs->fields('value'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $config;

		// Initialize URLs
		$this->ViewUrl = $config->ViewUrl();
		$this->EditUrl = $config->EditUrl();
		$this->InlineEditUrl = $config->InlineEditUrl();
		$this->CopyUrl = $config->CopyUrl();
		$this->InlineCopyUrl = $config->InlineCopyUrl();
		$this->DeleteUrl = $config->DeleteUrl();

		// Call Row_Rendering event
		$config->Row_Rendering();

		// Common render codes for all row types
		// key

		$config->key->CellCssStyle = ""; $config->key->CellCssClass = "";
		$config->key->CellAttrs = array(); $config->key->ViewAttrs = array(); $config->key->EditAttrs = array();

		// value
		$config->value->CellCssStyle = ""; $config->value->CellCssClass = "";
		$config->value->CellAttrs = array(); $config->value->ViewAttrs = array(); $config->value->EditAttrs = array();
		if ($config->RowType == EW_ROWTYPE_VIEW) { // View row

			// key
			$config->key->ViewValue = $config->key->CurrentValue;
			$config->key->CssStyle = "";
			$config->key->CssClass = "";
			$config->key->ViewCustomAttributes = "";

			// value
			$config->value->ViewValue = $config->value->CurrentValue;
			$config->value->CssStyle = "";
			$config->value->CssClass = "";
			$config->value->ViewCustomAttributes = "";

			// key
			$config->key->HrefValue = "";
			$config->key->TooltipValue = "";

			// value
			$config->value->HrefValue = "";
			$config->value->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($config->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$config->Row_Rendered();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>

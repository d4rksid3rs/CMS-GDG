<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "questionsinfo.php" ?>
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
$questions_list = new cquestions_list();
$Page =& $questions_list;

// Page init
$questions_list->Page_Init();

// Page main
$questions_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($questions->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var questions_list = new ew_Page("questions_list");

// page properties
questions_list.PageID = "list"; // page ID
questions_list.FormID = "fquestionslist"; // form ID
var EW_PAGE_ID = questions_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
questions_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
questions_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
questions_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($questions->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$questions_list->lTotalRecs = $questions->SelectRecordCount();
	} else {
		if ($rs = $questions_list->LoadRecordset())
			$questions_list->lTotalRecs = $rs->RecordCount();
	}
	$questions_list->lStartRec = 1;
	if ($questions_list->lDisplayRecs <= 0 || ($questions->Export <> "" && $questions->ExportAll)) // Display all records
		$questions_list->lDisplayRecs = $questions_list->lTotalRecs;
	if (!($questions->Export <> "" && $questions->ExportAll))
		$questions_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $questions_list->LoadRecordset($questions_list->lStartRec-1, $questions_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $questions->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($questions->Export == "" && $questions->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(questions_list);" style="text-decoration: none;"><img id="questions_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="questions_list_SearchPanel">
<form name="fquestionslistsrch" id="fquestionslistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="questions">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($questions->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $questions_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($questions->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($questions->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($questions->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$questions_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fquestionslist" id="fquestionslist" class="ewForm" action="" method="post">
<div id="gmp_questions" class="ewGridMiddlePanel">
<?php if ($questions_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $questions->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$questions_list->RenderListOptions();

// Render list options (header, left)
$questions_list->ListOptions->Render("header", "left");
?>
<?php if ($questions->id->Visible) { // id ?>
	<?php if ($questions->SortUrl($questions->id) == "") { ?>
		<td><?php echo $questions->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $questions->SortUrl($questions->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $questions->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($questions->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($questions->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($questions->Question->Visible) { // Question ?>
	<?php if ($questions->SortUrl($questions->Question) == "") { ?>
		<td><?php echo $questions->Question->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $questions->SortUrl($questions->Question) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $questions->Question->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($questions->Question->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($questions->Question->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$questions_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($questions->ExportAll && $questions->Export <> "") {
	$questions_list->lStopRec = $questions_list->lTotalRecs;
} else {
	$questions_list->lStopRec = $questions_list->lStartRec + $questions_list->lDisplayRecs - 1; // Set the last record to display
}
$questions_list->lRecCount = $questions_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $questions_list->lStartRec > 1)
		$rs->Move($questions_list->lStartRec - 1);
}

// Initialize aggregate
$questions->RowType = EW_ROWTYPE_AGGREGATEINIT;
$questions_list->RenderRow();
$questions_list->lRowCnt = 0;
while (($questions->CurrentAction == "gridadd" || !$rs->EOF) &&
	$questions_list->lRecCount < $questions_list->lStopRec) {
	$questions_list->lRecCount++;
	if (intval($questions_list->lRecCount) >= intval($questions_list->lStartRec)) {
		$questions_list->lRowCnt++;

	// Init row class and style
	$questions->CssClass = "";
	$questions->CssStyle = "";
	$questions->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($questions->CurrentAction == "gridadd") {
		$questions_list->LoadDefaultValues(); // Load default values
	} else {
		$questions_list->LoadRowValues($rs); // Load row values
	}
	$questions->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$questions_list->RenderRow();

	// Render list options
	$questions_list->RenderListOptions();
?>
	<tr<?php echo $questions->RowAttributes() ?>>
<?php

// Render list options (body, left)
$questions_list->ListOptions->Render("body", "left");
?>
	<?php if ($questions->id->Visible) { // id ?>
		<td<?php echo $questions->id->CellAttributes() ?>>
<div<?php echo $questions->id->ViewAttributes() ?>><?php echo $questions->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($questions->Question->Visible) { // Question ?>
		<td<?php echo $questions->Question->CellAttributes() ?>>
<div<?php echo $questions->Question->ViewAttributes() ?>><?php echo $questions->Question->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$questions_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($questions->CurrentAction <> "gridadd")
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
<?php if ($questions->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($questions->CurrentAction <> "gridadd" && $questions->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($questions_list->Pager)) $questions_list->Pager = new cPrevNextPager($questions_list->lStartRec, $questions_list->lDisplayRecs, $questions_list->lTotalRecs) ?>
<?php if ($questions_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($questions_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $questions_list->PageUrl() ?>start=<?php echo $questions_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($questions_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $questions_list->PageUrl() ?>start=<?php echo $questions_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $questions_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($questions_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $questions_list->PageUrl() ?>start=<?php echo $questions_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($questions_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $questions_list->PageUrl() ?>start=<?php echo $questions_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $questions_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $questions_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $questions_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $questions_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($questions_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($questions_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $questions_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($questions->Export == "" && $questions->CurrentAction == "") { ?>
<?php } ?>
<?php if ($questions->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$questions_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cquestions_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'questions';

	// Page object name
	var $PageObjName = 'questions_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $questions;
		if ($questions->UseTokenInUrl) $PageUrl .= "t=" . $questions->TableVar . "&"; // Add page token
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
		global $objForm, $questions;
		if ($questions->UseTokenInUrl) {
			if ($objForm)
				return ($questions->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($questions->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cquestions_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (questions)
		$GLOBALS["questions"] = new cquestions();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["questions"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "questionsdelete.php";
		$this->MultiUpdateUrl = "questionsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'questions', TRUE);

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
		global $questions;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$questions->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$questions->Export = $_POST["exporttype"];
		} else {
			$questions->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $questions->Export; // Get export parameter, used in header
		$gsExportFile = $questions->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $questions;

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
			$questions->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($questions->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $questions->getRecordsPerPage(); // Restore from Session
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
		$questions->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$questions->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$questions->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $questions->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$questions->setSessionWhere($sFilter);
		$questions->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $questions;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $questions->Question, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $questions->caseA, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $questions->caseB, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $questions->caseC, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $questions->caseD, $Keyword);
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
		global $Security, $questions;
		$sSearchStr = "";
		$sSearchKeyword = $questions->BasicSearchKeyword;
		$sSearchType = $questions->BasicSearchType;
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
			$questions->setSessionBasicSearchKeyword($sSearchKeyword);
			$questions->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $questions;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$questions->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $questions;
		$questions->setSessionBasicSearchKeyword("");
		$questions->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $questions;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$questions->BasicSearchKeyword = $questions->getSessionBasicSearchKeyword();
			$questions->BasicSearchType = $questions->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $questions;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$questions->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$questions->CurrentOrderType = @$_GET["ordertype"];
			$questions->UpdateSort($questions->id); // id
			$questions->UpdateSort($questions->Question); // Question
			$questions->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $questions;
		$sOrderBy = $questions->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($questions->SqlOrderBy() <> "") {
				$sOrderBy = $questions->SqlOrderBy();
				$questions->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $questions;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$questions->setSessionOrderBy($sOrderBy);
				$questions->id->setSort("");
				$questions->Question->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$questions->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $questions;

		// "view"
		$this->ListOptions->Add("view");
		$item =& $this->ListOptions->Items["view"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$this->ListOptions->Add("copy");
		$item =& $this->ListOptions->Items["copy"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "delete"
		$this->ListOptions->Add("delete");
		$item =& $this->ListOptions->Items["delete"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($questions->Export <> "" ||
			$questions->CurrentAction == "gridadd" ||
			$questions->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $questions;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
		}

		// "delete"
		$oListOpt =& $this->ListOptions->Items["delete"];
		if ($Security->IsLoggedIn() && $oListOpt->Visible)
			$oListOpt->Body = "<a" . "" . " href=\"" . $this->DeleteUrl . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $questions;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $questions;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$questions->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$questions->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $questions->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$questions->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$questions->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$questions->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $questions;
		$questions->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$questions->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $questions;

		// Call Recordset Selecting event
		$questions->Recordset_Selecting($questions->CurrentFilter);

		// Load List page SQL
		$sSql = $questions->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$questions->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $questions;
		$sFilter = $questions->KeyFilter();

		// Call Row Selecting event
		$questions->Row_Selecting($sFilter);

		// Load SQL based on filter
		$questions->CurrentFilter = $sFilter;
		$sSql = $questions->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$questions->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $questions;
		$questions->id->setDbValue($rs->fields('id'));
		$questions->idLevel->setDbValue($rs->fields('idLevel'));
		$questions->Question->setDbValue($rs->fields('Question'));
		$questions->caseA->setDbValue($rs->fields('caseA'));
		$questions->caseB->setDbValue($rs->fields('caseB'));
		$questions->caseC->setDbValue($rs->fields('caseC'));
		$questions->caseD->setDbValue($rs->fields('caseD'));
		$questions->trueCase->setDbValue($rs->fields('trueCase'));
		$questions->Money->setDbValue($rs->fields('Money'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $questions;

		// Initialize URLs
		$this->ViewUrl = $questions->ViewUrl();
		$this->EditUrl = $questions->EditUrl();
		$this->InlineEditUrl = $questions->InlineEditUrl();
		$this->CopyUrl = $questions->CopyUrl();
		$this->InlineCopyUrl = $questions->InlineCopyUrl();
		$this->DeleteUrl = $questions->DeleteUrl();

		// Call Row_Rendering event
		$questions->Row_Rendering();

		// Common render codes for all row types
		// id

		$questions->id->CellCssStyle = ""; $questions->id->CellCssClass = "";
		$questions->id->CellAttrs = array(); $questions->id->ViewAttrs = array(); $questions->id->EditAttrs = array();

		// Question
		$questions->Question->CellCssStyle = ""; $questions->Question->CellCssClass = "";
		$questions->Question->CellAttrs = array(); $questions->Question->ViewAttrs = array(); $questions->Question->EditAttrs = array();
		if ($questions->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$questions->id->ViewValue = $questions->id->CurrentValue;
			$questions->id->CssStyle = "";
			$questions->id->CssClass = "";
			$questions->id->ViewCustomAttributes = "";

			// idLevel
			$questions->idLevel->ViewValue = $questions->idLevel->CurrentValue;
			$questions->idLevel->CssStyle = "";
			$questions->idLevel->CssClass = "";
			$questions->idLevel->ViewCustomAttributes = "";

			// Question
			$questions->Question->ViewValue = $questions->Question->CurrentValue;
			$questions->Question->CssStyle = "";
			$questions->Question->CssClass = "";
			$questions->Question->ViewCustomAttributes = "";

			// trueCase
			if (strval($questions->trueCase->CurrentValue) <> "") {
				switch ($questions->trueCase->CurrentValue) {
					case "1":
						$questions->trueCase->ViewValue = "1";
						break;
					case "2":
						$questions->trueCase->ViewValue = "2";
						break;
					case "3":
						$questions->trueCase->ViewValue = "3";
						break;
					case "4":
						$questions->trueCase->ViewValue = "4";
						break;
					default:
						$questions->trueCase->ViewValue = $questions->trueCase->CurrentValue;
				}
			} else {
				$questions->trueCase->ViewValue = NULL;
			}
			$questions->trueCase->CssStyle = "";
			$questions->trueCase->CssClass = "";
			$questions->trueCase->ViewCustomAttributes = "";

			// Money
			$questions->Money->ViewValue = $questions->Money->CurrentValue;
			$questions->Money->CssStyle = "";
			$questions->Money->CssClass = "";
			$questions->Money->ViewCustomAttributes = "";

			// id
			$questions->id->HrefValue = "";
			$questions->id->TooltipValue = "";

			// Question
			$questions->Question->HrefValue = "";
			$questions->Question->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($questions->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$questions->Row_Rendered();
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

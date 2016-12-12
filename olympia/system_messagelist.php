<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "system_messageinfo.php" ?>
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
$system_message_list = new csystem_message_list();
$Page =& $system_message_list;

// Page init
$system_message_list->Page_Init();

// Page main
$system_message_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($system_message->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var system_message_list = new ew_Page("system_message_list");

// page properties
system_message_list.PageID = "list"; // page ID
system_message_list.FormID = "fsystem_messagelist"; // form ID
var EW_PAGE_ID = system_message_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
system_message_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
system_message_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
system_message_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($system_message->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$system_message_list->lTotalRecs = $system_message->SelectRecordCount();
	} else {
		if ($rs = $system_message_list->LoadRecordset())
			$system_message_list->lTotalRecs = $rs->RecordCount();
	}
	$system_message_list->lStartRec = 1;
	if ($system_message_list->lDisplayRecs <= 0 || ($system_message->Export <> "" && $system_message->ExportAll)) // Display all records
		$system_message_list->lDisplayRecs = $system_message_list->lTotalRecs;
	if (!($system_message->Export <> "" && $system_message->ExportAll))
		$system_message_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $system_message_list->LoadRecordset($system_message_list->lStartRec-1, $system_message_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $system_message->TableCaption() ?>
</span></p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($system_message->Export == "" && $system_message->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(system_message_list);" style="text-decoration: none;"><img id="system_message_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="system_message_list_SearchPanel">
<form name="fsystem_messagelistsrch" id="fsystem_messagelistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="system_message">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($system_message->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $system_message_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($system_message->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($system_message->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($system_message->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$system_message_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="fsystem_messagelist" id="fsystem_messagelist" class="ewForm" action="" method="post">
<div id="gmp_system_message" class="ewGridMiddlePanel">
<?php if ($system_message_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $system_message->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$system_message_list->RenderListOptions();

// Render list options (header, left)
$system_message_list->ListOptions->Render("header", "left");
?>
<?php if ($system_message->id->Visible) { // id ?>
	<?php if ($system_message->SortUrl($system_message->id) == "") { ?>
		<td><?php echo $system_message->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $system_message->SortUrl($system_message->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $system_message->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($system_message->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($system_message->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($system_message->content->Visible) { // content ?>
	<?php if ($system_message->SortUrl($system_message->content) == "") { ?>
		<td><?php echo $system_message->content->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $system_message->SortUrl($system_message->content) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $system_message->content->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($system_message->content->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($system_message->content->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($system_message->status->Visible) { // status ?>
	<?php if ($system_message->SortUrl($system_message->status) == "") { ?>
		<td><?php echo $system_message->status->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $system_message->SortUrl($system_message->status) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $system_message->status->FldCaption() ?></td><td style="width: 10px;"><?php if ($system_message->status->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($system_message->status->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($system_message->message_type->Visible) { // message_type ?>
	<?php if ($system_message->SortUrl($system_message->message_type) == "") { ?>
		<td><?php echo $system_message->message_type->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $system_message->SortUrl($system_message->message_type) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $system_message->message_type->FldCaption() ?></td><td style="width: 10px;"><?php if ($system_message->message_type->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($system_message->message_type->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($system_message->date_end->Visible) { // date_end ?>
	<?php if ($system_message->SortUrl($system_message->date_end) == "") { ?>
		<td><?php echo $system_message->date_end->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $system_message->SortUrl($system_message->date_end) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $system_message->date_end->FldCaption() ?></td><td style="width: 10px;"><?php if ($system_message->date_end->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($system_message->date_end->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$system_message_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($system_message->ExportAll && $system_message->Export <> "") {
	$system_message_list->lStopRec = $system_message_list->lTotalRecs;
} else {
	$system_message_list->lStopRec = $system_message_list->lStartRec + $system_message_list->lDisplayRecs - 1; // Set the last record to display
}
$system_message_list->lRecCount = $system_message_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $system_message_list->lStartRec > 1)
		$rs->Move($system_message_list->lStartRec - 1);
}

// Initialize aggregate
$system_message->RowType = EW_ROWTYPE_AGGREGATEINIT;
$system_message_list->RenderRow();
$system_message_list->lRowCnt = 0;
while (($system_message->CurrentAction == "gridadd" || !$rs->EOF) &&
	$system_message_list->lRecCount < $system_message_list->lStopRec) {
	$system_message_list->lRecCount++;
	if (intval($system_message_list->lRecCount) >= intval($system_message_list->lStartRec)) {
		$system_message_list->lRowCnt++;

	// Init row class and style
	$system_message->CssClass = "";
	$system_message->CssStyle = "";
	$system_message->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($system_message->CurrentAction == "gridadd") {
		$system_message_list->LoadDefaultValues(); // Load default values
	} else {
		$system_message_list->LoadRowValues($rs); // Load row values
	}
	$system_message->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$system_message_list->RenderRow();

	// Render list options
	$system_message_list->RenderListOptions();
?>
	<tr<?php echo $system_message->RowAttributes() ?>>
<?php

// Render list options (body, left)
$system_message_list->ListOptions->Render("body", "left");
?>
	<?php if ($system_message->id->Visible) { // id ?>
		<td<?php echo $system_message->id->CellAttributes() ?>>
<div<?php echo $system_message->id->ViewAttributes() ?>><?php echo $system_message->id->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($system_message->content->Visible) { // content ?>
		<td<?php echo $system_message->content->CellAttributes() ?>>
<div<?php echo $system_message->content->ViewAttributes() ?>><?php echo $system_message->content->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($system_message->status->Visible) { // status ?>
		<td<?php echo $system_message->status->CellAttributes() ?>>
<div<?php echo $system_message->status->ViewAttributes() ?>><?php echo $system_message->status->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($system_message->message_type->Visible) { // message_type ?>
		<td<?php echo $system_message->message_type->CellAttributes() ?>>
<div<?php echo $system_message->message_type->ViewAttributes() ?>><?php echo $system_message->message_type->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($system_message->date_end->Visible) { // date_end ?>
		<td<?php echo $system_message->date_end->CellAttributes() ?>>
<div<?php echo $system_message->date_end->ViewAttributes() ?>><?php echo $system_message->date_end->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$system_message_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($system_message->CurrentAction <> "gridadd")
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
<?php if ($system_message->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($system_message->CurrentAction <> "gridadd" && $system_message->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($system_message_list->Pager)) $system_message_list->Pager = new cPrevNextPager($system_message_list->lStartRec, $system_message_list->lDisplayRecs, $system_message_list->lTotalRecs) ?>
<?php if ($system_message_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($system_message_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $system_message_list->PageUrl() ?>start=<?php echo $system_message_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($system_message_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $system_message_list->PageUrl() ?>start=<?php echo $system_message_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $system_message_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($system_message_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $system_message_list->PageUrl() ?>start=<?php echo $system_message_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($system_message_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $system_message_list->PageUrl() ?>start=<?php echo $system_message_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $system_message_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $system_message_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $system_message_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $system_message_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($system_message_list->sSrchWhere == "0=101") { ?>
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
<?php //if ($system_message_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $system_message_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($system_message->Export == "" && $system_message->CurrentAction == "") { ?>
<?php } ?>
<?php if ($system_message->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$system_message_list->Page_Terminate();
?>
<?php

//
// Page class
//
class csystem_message_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'system_message';

	// Page object name
	var $PageObjName = 'system_message_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $system_message;
		if ($system_message->UseTokenInUrl) $PageUrl .= "t=" . $system_message->TableVar . "&"; // Add page token
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
		global $objForm, $system_message;
		if ($system_message->UseTokenInUrl) {
			if ($objForm)
				return ($system_message->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($system_message->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function csystem_message_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (system_message)
		$GLOBALS["system_message"] = new csystem_message();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["system_message"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "system_messagedelete.php";
		$this->MultiUpdateUrl = "system_messageupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'system_message', TRUE);

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
		global $system_message;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$system_message->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$system_message->Export = $_POST["exporttype"];
		} else {
			$system_message->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $system_message->Export; // Get export parameter, used in header
		$gsExportFile = $system_message->TableVar; // Get export file, used in header

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
		global $objForm, $Language, $gsSearchError, $Security, $system_message;

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
			$system_message->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($system_message->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $system_message->getRecordsPerPage(); // Restore from Session
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
		$system_message->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$system_message->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$system_message->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $system_message->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$system_message->setSessionWhere($sFilter);
		$system_message->CurrentFilter = "";
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $system_message;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $system_message->content, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $system_message->url, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $system_message->cp, $Keyword);
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
		global $Security, $system_message;
		$sSearchStr = "";
		$sSearchKeyword = $system_message->BasicSearchKeyword;
		$sSearchType = $system_message->BasicSearchType;
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
			$system_message->setSessionBasicSearchKeyword($sSearchKeyword);
			$system_message->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $system_message;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$system_message->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $system_message;
		$system_message->setSessionBasicSearchKeyword("");
		$system_message->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $system_message;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$system_message->BasicSearchKeyword = $system_message->getSessionBasicSearchKeyword();
			$system_message->BasicSearchType = $system_message->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $system_message;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$system_message->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$system_message->CurrentOrderType = @$_GET["ordertype"];
			$system_message->UpdateSort($system_message->id); // id
			$system_message->UpdateSort($system_message->content); // content
			$system_message->UpdateSort($system_message->status); // status
			$system_message->UpdateSort($system_message->message_type); // message_type
			$system_message->UpdateSort($system_message->date_end); // date_end
			$system_message->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $system_message;
		$sOrderBy = $system_message->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($system_message->SqlOrderBy() <> "") {
				$sOrderBy = $system_message->SqlOrderBy();
				$system_message->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $system_message;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$system_message->setSessionOrderBy($sOrderBy);
				$system_message->id->setSort("");
				$system_message->content->setSort("");
				$system_message->status->setSort("");
				$system_message->message_type->setSort("");
				$system_message->date_end->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$system_message->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $system_message;

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
		if ($system_message->Export <> "" ||
			$system_message->CurrentAction == "gridadd" ||
			$system_message->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $system_message;
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
		global $Security, $Language, $system_message;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $system_message;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$system_message->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$system_message->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $system_message->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$system_message->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$system_message->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$system_message->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $system_message;
		$system_message->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$system_message->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $system_message;

		// Call Recordset Selecting event
		$system_message->Recordset_Selecting($system_message->CurrentFilter);

		// Load List page SQL
		$sSql = $system_message->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$system_message->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $system_message;
		$sFilter = $system_message->KeyFilter();

		// Call Row Selecting event
		$system_message->Row_Selecting($sFilter);

		// Load SQL based on filter
		$system_message->CurrentFilter = $sFilter;
		$sSql = $system_message->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$system_message->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $system_message;
		$system_message->id->setDbValue($rs->fields('id'));
		$system_message->content->setDbValue($rs->fields('content'));
		$system_message->status->setDbValue($rs->fields('status'));
		$system_message->message_type->setDbValue($rs->fields('message_type'));
		$system_message->bonus->setDbValue($rs->fields('bonus'));
		$system_message->url->setDbValue($rs->fields('url'));
		$system_message->cp->setDbValue($rs->fields('cp'));
		$system_message->date_begin->setDbValue($rs->fields('date_begin'));
		$system_message->date_end->setDbValue($rs->fields('date_end'));
		$system_message->date_created->setDbValue($rs->fields('date_created'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $system_message;

		// Initialize URLs
		$this->ViewUrl = $system_message->ViewUrl();
		$this->EditUrl = $system_message->EditUrl();
		$this->InlineEditUrl = $system_message->InlineEditUrl();
		$this->CopyUrl = $system_message->CopyUrl();
		$this->InlineCopyUrl = $system_message->InlineCopyUrl();
		$this->DeleteUrl = $system_message->DeleteUrl();

		// Call Row_Rendering event
		$system_message->Row_Rendering();

		// Common render codes for all row types
		// id

		$system_message->id->CellCssStyle = ""; $system_message->id->CellCssClass = "";
		$system_message->id->CellAttrs = array(); $system_message->id->ViewAttrs = array(); $system_message->id->EditAttrs = array();

		// content
		$system_message->content->CellCssStyle = ""; $system_message->content->CellCssClass = "";
		$system_message->content->CellAttrs = array(); $system_message->content->ViewAttrs = array(); $system_message->content->EditAttrs = array();

		// status
		$system_message->status->CellCssStyle = ""; $system_message->status->CellCssClass = "";
		$system_message->status->CellAttrs = array(); $system_message->status->ViewAttrs = array(); $system_message->status->EditAttrs = array();

		// message_type
		$system_message->message_type->CellCssStyle = ""; $system_message->message_type->CellCssClass = "";
		$system_message->message_type->CellAttrs = array(); $system_message->message_type->ViewAttrs = array(); $system_message->message_type->EditAttrs = array();

		// date_end
		$system_message->date_end->CellCssStyle = ""; $system_message->date_end->CellCssClass = "";
		$system_message->date_end->CellAttrs = array(); $system_message->date_end->ViewAttrs = array(); $system_message->date_end->EditAttrs = array();
		if ($system_message->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$system_message->id->ViewValue = $system_message->id->CurrentValue;
			$system_message->id->CssStyle = "";
			$system_message->id->CssClass = "";
			$system_message->id->ViewCustomAttributes = "";

			// content
			$system_message->content->ViewValue = $system_message->content->CurrentValue;
			$system_message->content->CssStyle = "";
			$system_message->content->CssClass = "";
			$system_message->content->ViewCustomAttributes = "";

			// status
			$system_message->status->ViewValue = $system_message->status->CurrentValue;
			$system_message->status->CssStyle = "";
			$system_message->status->CssClass = "";
			$system_message->status->ViewCustomAttributes = "";

			// message_type
			if (strval($system_message->message_type->CurrentValue) <> "") {
				switch ($system_message->message_type->CurrentValue) {
					case "0":
						$system_message->message_type->ViewValue = "0";
						break;
					case "1":
						$system_message->message_type->ViewValue = "1";
						break;
					default:
						$system_message->message_type->ViewValue = $system_message->message_type->CurrentValue;
				}
			} else {
				$system_message->message_type->ViewValue = NULL;
			}
			$system_message->message_type->CssStyle = "";
			$system_message->message_type->CssClass = "";
			$system_message->message_type->ViewCustomAttributes = "";

			// bonus
			$system_message->bonus->ViewValue = $system_message->bonus->CurrentValue;
			$system_message->bonus->CssStyle = "";
			$system_message->bonus->CssClass = "";
			$system_message->bonus->ViewCustomAttributes = "";

			// date_begin
			$system_message->date_begin->ViewValue = $system_message->date_begin->CurrentValue;
			$system_message->date_begin->ViewValue = ew_FormatDateTime($system_message->date_begin->ViewValue, 5);
			$system_message->date_begin->CssStyle = "";
			$system_message->date_begin->CssClass = "";
			$system_message->date_begin->ViewCustomAttributes = "";

			// date_end
			$system_message->date_end->ViewValue = $system_message->date_end->CurrentValue;
			$system_message->date_end->ViewValue = ew_FormatDateTime($system_message->date_end->ViewValue, 5);
			$system_message->date_end->CssStyle = "";
			$system_message->date_end->CssClass = "";
			$system_message->date_end->ViewCustomAttributes = "";

			// date_created
			$system_message->date_created->ViewValue = $system_message->date_created->CurrentValue;
			$system_message->date_created->ViewValue = ew_FormatDateTime($system_message->date_created->ViewValue, 5);
			$system_message->date_created->CssStyle = "";
			$system_message->date_created->CssClass = "";
			$system_message->date_created->ViewCustomAttributes = "";

			// id
			$system_message->id->HrefValue = "";
			$system_message->id->TooltipValue = "";

			// content
			$system_message->content->HrefValue = "";
			$system_message->content->TooltipValue = "";

			// status
			$system_message->status->HrefValue = "";
			$system_message->status->TooltipValue = "";

			// message_type
			$system_message->message_type->HrefValue = "";
			$system_message->message_type->TooltipValue = "";

			// date_end
			$system_message->date_end->HrefValue = "";
			$system_message->date_end->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($system_message->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$system_message->Row_Rendered();
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

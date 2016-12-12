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
$system_message_view = new csystem_message_view();
$Page =& $system_message_view;

// Page init
$system_message_view->Page_Init();

// Page main
$system_message_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($system_message->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var system_message_view = new ew_Page("system_message_view");

// page properties
system_message_view.PageID = "view"; // page ID
system_message_view.FormID = "fsystem_messageview"; // form ID
var EW_PAGE_ID = system_message_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
system_message_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
system_message_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
system_message_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $system_message->TableCaption() ?>
<br><br>
<?php if ($system_message->Export == "") { ?>
<a href="<?php echo $system_message_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $system_message_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $system_message_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $system_message_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $system_message_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$system_message_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($system_message->id->Visible) { // id ?>
	<tr<?php echo $system_message->id->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->id->FldCaption() ?></td>
		<td<?php echo $system_message->id->CellAttributes() ?>>
<div<?php echo $system_message->id->ViewAttributes() ?>><?php echo $system_message->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->content->Visible) { // content ?>
	<tr<?php echo $system_message->content->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->content->FldCaption() ?></td>
		<td<?php echo $system_message->content->CellAttributes() ?>>
<div<?php echo $system_message->content->ViewAttributes() ?>><?php echo $system_message->content->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->status->Visible) { // status ?>
	<tr<?php echo $system_message->status->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->status->FldCaption() ?></td>
		<td<?php echo $system_message->status->CellAttributes() ?>>
<div<?php echo $system_message->status->ViewAttributes() ?>><?php echo $system_message->status->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->message_type->Visible) { // message_type ?>
	<tr<?php echo $system_message->message_type->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->message_type->FldCaption() ?></td>
		<td<?php echo $system_message->message_type->CellAttributes() ?>>
<div<?php echo $system_message->message_type->ViewAttributes() ?>><?php echo $system_message->message_type->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->bonus->Visible) { // bonus ?>
	<tr<?php echo $system_message->bonus->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->bonus->FldCaption() ?></td>
		<td<?php echo $system_message->bonus->CellAttributes() ?>>
<div<?php echo $system_message->bonus->ViewAttributes() ?>><?php echo $system_message->bonus->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->url->Visible) { // url ?>
	<tr<?php echo $system_message->url->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->url->FldCaption() ?></td>
		<td<?php echo $system_message->url->CellAttributes() ?>>
<div<?php echo $system_message->url->ViewAttributes() ?>><?php echo $system_message->url->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->cp->Visible) { // cp ?>
	<tr<?php echo $system_message->cp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->cp->FldCaption() ?></td>
		<td<?php echo $system_message->cp->CellAttributes() ?>>
<div<?php echo $system_message->cp->ViewAttributes() ?>><?php echo $system_message->cp->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->date_begin->Visible) { // date_begin ?>
	<tr<?php echo $system_message->date_begin->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->date_begin->FldCaption() ?></td>
		<td<?php echo $system_message->date_begin->CellAttributes() ?>>
<div<?php echo $system_message->date_begin->ViewAttributes() ?>><?php echo $system_message->date_begin->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->date_end->Visible) { // date_end ?>
	<tr<?php echo $system_message->date_end->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->date_end->FldCaption() ?></td>
		<td<?php echo $system_message->date_end->CellAttributes() ?>>
<div<?php echo $system_message->date_end->ViewAttributes() ?>><?php echo $system_message->date_end->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($system_message->date_created->Visible) { // date_created ?>
	<tr<?php echo $system_message->date_created->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->date_created->FldCaption() ?></td>
		<td<?php echo $system_message->date_created->CellAttributes() ?>>
<div<?php echo $system_message->date_created->ViewAttributes() ?>><?php echo $system_message->date_created->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
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
$system_message_view->Page_Terminate();
?>
<?php

//
// Page class
//
class csystem_message_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'system_message';

	// Page object name
	var $PageObjName = 'system_message_view';

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
	function csystem_message_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (system_message)
		$GLOBALS["system_message"] = new csystem_message();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'system_message', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
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
	var $lDisplayRecs = 1;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $lRecCnt;
	var $arRecKey = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $system_message;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$system_message->id->setQueryStringValue($_GET["id"]);
				$this->arRecKey["id"] = $system_message->id->QueryStringValue;
			} else {
				$sReturnUrl = "system_messagelist.php"; // Return to list
			}

			// Get action
			$system_message->CurrentAction = "I"; // Display form
			switch ($system_message->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "system_messagelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "system_messagelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$system_message->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
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
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id=" . urlencode($system_message->id->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id=" . urlencode($system_message->id->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id=" . urlencode($system_message->id->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id=" . urlencode($system_message->id->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id=" . urlencode($system_message->id->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id=" . urlencode($system_message->id->CurrentValue);
		$this->AddUrl = $system_message->AddUrl();
		$this->EditUrl = $system_message->EditUrl();
		$this->CopyUrl = $system_message->CopyUrl();
		$this->DeleteUrl = $system_message->DeleteUrl();
		$this->ListUrl = $system_message->ListUrl();

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

		// bonus
		$system_message->bonus->CellCssStyle = ""; $system_message->bonus->CellCssClass = "";
		$system_message->bonus->CellAttrs = array(); $system_message->bonus->ViewAttrs = array(); $system_message->bonus->EditAttrs = array();

		// url
		$system_message->url->CellCssStyle = ""; $system_message->url->CellCssClass = "";
		$system_message->url->CellAttrs = array(); $system_message->url->ViewAttrs = array(); $system_message->url->EditAttrs = array();

		// cp
		$system_message->cp->CellCssStyle = ""; $system_message->cp->CellCssClass = "";
		$system_message->cp->CellAttrs = array(); $system_message->cp->ViewAttrs = array(); $system_message->cp->EditAttrs = array();

		// date_begin
		$system_message->date_begin->CellCssStyle = ""; $system_message->date_begin->CellCssClass = "";
		$system_message->date_begin->CellAttrs = array(); $system_message->date_begin->ViewAttrs = array(); $system_message->date_begin->EditAttrs = array();

		// date_end
		$system_message->date_end->CellCssStyle = ""; $system_message->date_end->CellCssClass = "";
		$system_message->date_end->CellAttrs = array(); $system_message->date_end->ViewAttrs = array(); $system_message->date_end->EditAttrs = array();

		// date_created
		$system_message->date_created->CellCssStyle = ""; $system_message->date_created->CellCssClass = "";
		$system_message->date_created->CellAttrs = array(); $system_message->date_created->ViewAttrs = array(); $system_message->date_created->EditAttrs = array();
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

			// url
			$system_message->url->ViewValue = $system_message->url->CurrentValue;
			$system_message->url->CssStyle = "";
			$system_message->url->CssClass = "";
			$system_message->url->ViewCustomAttributes = "";

			// cp
			$system_message->cp->ViewValue = $system_message->cp->CurrentValue;
			$system_message->cp->CssStyle = "";
			$system_message->cp->CssClass = "";
			$system_message->cp->ViewCustomAttributes = "";

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

			// bonus
			$system_message->bonus->HrefValue = "";
			$system_message->bonus->TooltipValue = "";

			// url
			$system_message->url->HrefValue = "";
			$system_message->url->TooltipValue = "";

			// cp
			$system_message->cp->HrefValue = "";
			$system_message->cp->TooltipValue = "";

			// date_begin
			$system_message->date_begin->HrefValue = "";
			$system_message->date_begin->TooltipValue = "";

			// date_end
			$system_message->date_end->HrefValue = "";
			$system_message->date_end->TooltipValue = "";

			// date_created
			$system_message->date_created->HrefValue = "";
			$system_message->date_created->TooltipValue = "";
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
}
?>

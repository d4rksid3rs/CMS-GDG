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
$questions_view = new cquestions_view();
$Page =& $questions_view;

// Page init
$questions_view->Page_Init();

// Page main
$questions_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($questions->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var questions_view = new ew_Page("questions_view");

// page properties
questions_view.PageID = "view"; // page ID
questions_view.FormID = "fquestionsview"; // form ID
var EW_PAGE_ID = questions_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
questions_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
questions_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
questions_view.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $questions->TableCaption() ?>
<br><br>
<?php if ($questions->Export == "") { ?>
<a href="<?php echo $questions_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $questions_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $questions_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $questions_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $questions_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$questions_view->ShowMessage();
?>
<p>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($questions->id->Visible) { // id ?>
	<tr<?php echo $questions->id->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->id->FldCaption() ?></td>
		<td<?php echo $questions->id->CellAttributes() ?>>
<div<?php echo $questions->id->ViewAttributes() ?>><?php echo $questions->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->idLevel->Visible) { // idLevel ?>
	<tr<?php echo $questions->idLevel->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->idLevel->FldCaption() ?></td>
		<td<?php echo $questions->idLevel->CellAttributes() ?>>
<div<?php echo $questions->idLevel->ViewAttributes() ?>><?php echo $questions->idLevel->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->Question->Visible) { // Question ?>
	<tr<?php echo $questions->Question->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->Question->FldCaption() ?></td>
		<td<?php echo $questions->Question->CellAttributes() ?>>
<div<?php echo $questions->Question->ViewAttributes() ?>><?php echo $questions->Question->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->caseA->Visible) { // caseA ?>
	<tr<?php echo $questions->caseA->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseA->FldCaption() ?></td>
		<td<?php echo $questions->caseA->CellAttributes() ?>>
<div<?php echo $questions->caseA->ViewAttributes() ?>><?php echo $questions->caseA->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->caseB->Visible) { // caseB ?>
	<tr<?php echo $questions->caseB->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseB->FldCaption() ?></td>
		<td<?php echo $questions->caseB->CellAttributes() ?>>
<div<?php echo $questions->caseB->ViewAttributes() ?>><?php echo $questions->caseB->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->caseC->Visible) { // caseC ?>
	<tr<?php echo $questions->caseC->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseC->FldCaption() ?></td>
		<td<?php echo $questions->caseC->CellAttributes() ?>>
<div<?php echo $questions->caseC->ViewAttributes() ?>><?php echo $questions->caseC->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->caseD->Visible) { // caseD ?>
	<tr<?php echo $questions->caseD->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseD->FldCaption() ?></td>
		<td<?php echo $questions->caseD->CellAttributes() ?>>
<div<?php echo $questions->caseD->ViewAttributes() ?>><?php echo $questions->caseD->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->trueCase->Visible) { // trueCase ?>
	<tr<?php echo $questions->trueCase->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->trueCase->FldCaption() ?></td>
		<td<?php echo $questions->trueCase->CellAttributes() ?>>
<div<?php echo $questions->trueCase->ViewAttributes() ?>><?php echo $questions->trueCase->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($questions->Money->Visible) { // Money ?>
	<tr<?php echo $questions->Money->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->Money->FldCaption() ?></td>
		<td<?php echo $questions->Money->CellAttributes() ?>>
<div<?php echo $questions->Money->ViewAttributes() ?>><?php echo $questions->Money->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
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
$questions_view->Page_Terminate();
?>
<?php

//
// Page class
//
class cquestions_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'questions';

	// Page object name
	var $PageObjName = 'questions_view';

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
	function cquestions_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (questions)
		$GLOBALS["questions"] = new cquestions();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'questions', TRUE);

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
		global $questions;

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
		global $Language, $questions;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$questions->id->setQueryStringValue($_GET["id"]);
				$this->arRecKey["id"] = $questions->id->QueryStringValue;
			} else {
				$sReturnUrl = "questionslist.php"; // Return to list
			}

			// Get action
			$questions->CurrentAction = "I"; // Display form
			switch ($questions->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "questionslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "questionslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$questions->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
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
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id=" . urlencode($questions->id->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id=" . urlencode($questions->id->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id=" . urlencode($questions->id->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id=" . urlencode($questions->id->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id=" . urlencode($questions->id->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id=" . urlencode($questions->id->CurrentValue);
		$this->AddUrl = $questions->AddUrl();
		$this->EditUrl = $questions->EditUrl();
		$this->CopyUrl = $questions->CopyUrl();
		$this->DeleteUrl = $questions->DeleteUrl();
		$this->ListUrl = $questions->ListUrl();

		// Call Row_Rendering event
		$questions->Row_Rendering();

		// Common render codes for all row types
		// id

		$questions->id->CellCssStyle = ""; $questions->id->CellCssClass = "";
		$questions->id->CellAttrs = array(); $questions->id->ViewAttrs = array(); $questions->id->EditAttrs = array();

		// idLevel
		$questions->idLevel->CellCssStyle = ""; $questions->idLevel->CellCssClass = "";
		$questions->idLevel->CellAttrs = array(); $questions->idLevel->ViewAttrs = array(); $questions->idLevel->EditAttrs = array();

		// Question
		$questions->Question->CellCssStyle = ""; $questions->Question->CellCssClass = "";
		$questions->Question->CellAttrs = array(); $questions->Question->ViewAttrs = array(); $questions->Question->EditAttrs = array();

		// caseA
		$questions->caseA->CellCssStyle = ""; $questions->caseA->CellCssClass = "";
		$questions->caseA->CellAttrs = array(); $questions->caseA->ViewAttrs = array(); $questions->caseA->EditAttrs = array();

		// caseB
		$questions->caseB->CellCssStyle = ""; $questions->caseB->CellCssClass = "";
		$questions->caseB->CellAttrs = array(); $questions->caseB->ViewAttrs = array(); $questions->caseB->EditAttrs = array();

		// caseC
		$questions->caseC->CellCssStyle = ""; $questions->caseC->CellCssClass = "";
		$questions->caseC->CellAttrs = array(); $questions->caseC->ViewAttrs = array(); $questions->caseC->EditAttrs = array();

		// caseD
		$questions->caseD->CellCssStyle = ""; $questions->caseD->CellCssClass = "";
		$questions->caseD->CellAttrs = array(); $questions->caseD->ViewAttrs = array(); $questions->caseD->EditAttrs = array();

		// trueCase
		$questions->trueCase->CellCssStyle = ""; $questions->trueCase->CellCssClass = "";
		$questions->trueCase->CellAttrs = array(); $questions->trueCase->ViewAttrs = array(); $questions->trueCase->EditAttrs = array();

		// Money
		$questions->Money->CellCssStyle = ""; $questions->Money->CellCssClass = "";
		$questions->Money->CellAttrs = array(); $questions->Money->ViewAttrs = array(); $questions->Money->EditAttrs = array();
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

			// caseA
			$questions->caseA->ViewValue = $questions->caseA->CurrentValue;
			$questions->caseA->CssStyle = "";
			$questions->caseA->CssClass = "";
			$questions->caseA->ViewCustomAttributes = "";

			// caseB
			$questions->caseB->ViewValue = $questions->caseB->CurrentValue;
			$questions->caseB->CssStyle = "";
			$questions->caseB->CssClass = "";
			$questions->caseB->ViewCustomAttributes = "";

			// caseC
			$questions->caseC->ViewValue = $questions->caseC->CurrentValue;
			$questions->caseC->CssStyle = "";
			$questions->caseC->CssClass = "";
			$questions->caseC->ViewCustomAttributes = "";

			// caseD
			$questions->caseD->ViewValue = $questions->caseD->CurrentValue;
			$questions->caseD->CssStyle = "";
			$questions->caseD->CssClass = "";
			$questions->caseD->ViewCustomAttributes = "";

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

			// idLevel
			$questions->idLevel->HrefValue = "";
			$questions->idLevel->TooltipValue = "";

			// Question
			$questions->Question->HrefValue = "";
			$questions->Question->TooltipValue = "";

			// caseA
			$questions->caseA->HrefValue = "";
			$questions->caseA->TooltipValue = "";

			// caseB
			$questions->caseB->HrefValue = "";
			$questions->caseB->TooltipValue = "";

			// caseC
			$questions->caseC->HrefValue = "";
			$questions->caseC->TooltipValue = "";

			// caseD
			$questions->caseD->HrefValue = "";
			$questions->caseD->TooltipValue = "";

			// trueCase
			$questions->trueCase->HrefValue = "";
			$questions->trueCase->TooltipValue = "";

			// Money
			$questions->Money->HrefValue = "";
			$questions->Money->TooltipValue = "";
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
}
?>

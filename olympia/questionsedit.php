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
$questions_edit = new cquestions_edit();
$Page =& $questions_edit;

// Page init
$questions_edit->Page_Init();

// Page main
$questions_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var questions_edit = new ew_Page("questions_edit");

// page properties
questions_edit.PageID = "edit"; // page ID
questions_edit.FormID = "fquestionsedit"; // form ID
var EW_PAGE_ID = questions_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
questions_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idLevel"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($questions->idLevel->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Money"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($questions->Money->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
questions_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
questions_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
questions_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $questions->TableCaption() ?><br><br>
<a href="<?php echo $questions->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$questions_edit->ShowMessage();
?>
<form name="fquestionsedit" id="fquestionsedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return questions_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="questions">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($questions->id->Visible) { // id ?>
	<tr<?php echo $questions->id->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->id->FldCaption() ?></td>
		<td<?php echo $questions->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $questions->id->ViewAttributes() ?>><?php echo $questions->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($questions->id->CurrentValue) ?>">
</span><?php echo $questions->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->idLevel->Visible) { // idLevel ?>
	<tr<?php echo $questions->idLevel->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->idLevel->FldCaption() ?></td>
		<td<?php echo $questions->idLevel->CellAttributes() ?>><span id="el_idLevel">
<input type="text" name="x_idLevel" id="x_idLevel" title="<?php echo $questions->idLevel->FldTitle() ?>" size="30" value="<?php echo $questions->idLevel->EditValue ?>"<?php echo $questions->idLevel->EditAttributes() ?>>
</span><?php echo $questions->idLevel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->Question->Visible) { // Question ?>
	<tr<?php echo $questions->Question->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->Question->FldCaption() ?></td>
		<td<?php echo $questions->Question->CellAttributes() ?>><span id="el_Question">
<textarea name="x_Question" id="x_Question" title="<?php echo $questions->Question->FldTitle() ?>" cols="35" rows="4"<?php echo $questions->Question->EditAttributes() ?>><?php echo $questions->Question->EditValue ?></textarea>
</span><?php echo $questions->Question->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->caseA->Visible) { // caseA ?>
	<tr<?php echo $questions->caseA->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseA->FldCaption() ?></td>
		<td<?php echo $questions->caseA->CellAttributes() ?>><span id="el_caseA">
<textarea name="x_caseA" id="x_caseA" title="<?php echo $questions->caseA->FldTitle() ?>" cols="35" rows="4"<?php echo $questions->caseA->EditAttributes() ?>><?php echo $questions->caseA->EditValue ?></textarea>
</span><?php echo $questions->caseA->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->caseB->Visible) { // caseB ?>
	<tr<?php echo $questions->caseB->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseB->FldCaption() ?></td>
		<td<?php echo $questions->caseB->CellAttributes() ?>><span id="el_caseB">
<textarea name="x_caseB" id="x_caseB" title="<?php echo $questions->caseB->FldTitle() ?>" cols="35" rows="4"<?php echo $questions->caseB->EditAttributes() ?>><?php echo $questions->caseB->EditValue ?></textarea>
</span><?php echo $questions->caseB->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->caseC->Visible) { // caseC ?>
	<tr<?php echo $questions->caseC->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseC->FldCaption() ?></td>
		<td<?php echo $questions->caseC->CellAttributes() ?>><span id="el_caseC">
<textarea name="x_caseC" id="x_caseC" title="<?php echo $questions->caseC->FldTitle() ?>" cols="35" rows="4"<?php echo $questions->caseC->EditAttributes() ?>><?php echo $questions->caseC->EditValue ?></textarea>
</span><?php echo $questions->caseC->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->caseD->Visible) { // caseD ?>
	<tr<?php echo $questions->caseD->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->caseD->FldCaption() ?></td>
		<td<?php echo $questions->caseD->CellAttributes() ?>><span id="el_caseD">
<textarea name="x_caseD" id="x_caseD" title="<?php echo $questions->caseD->FldTitle() ?>" cols="35" rows="4"<?php echo $questions->caseD->EditAttributes() ?>><?php echo $questions->caseD->EditValue ?></textarea>
</span><?php echo $questions->caseD->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->trueCase->Visible) { // trueCase ?>
	<tr<?php echo $questions->trueCase->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->trueCase->FldCaption() ?></td>
		<td<?php echo $questions->trueCase->CellAttributes() ?>><span id="el_trueCase">
<select id="x_trueCase" name="x_trueCase" title="<?php echo $questions->trueCase->FldTitle() ?>"<?php echo $questions->trueCase->EditAttributes() ?>>
<?php
if (is_array($questions->trueCase->EditValue)) {
	$arwrk = $questions->trueCase->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($questions->trueCase->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $questions->trueCase->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($questions->Money->Visible) { // Money ?>
	<tr<?php echo $questions->Money->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $questions->Money->FldCaption() ?></td>
		<td<?php echo $questions->Money->CellAttributes() ?>><span id="el_Money">
<input type="text" name="x_Money" id="x_Money" title="<?php echo $questions->Money->FldTitle() ?>" size="30" value="<?php echo $questions->Money->EditValue ?>"<?php echo $questions->Money->EditAttributes() ?>>
</span><?php echo $questions->Money->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$questions_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class cquestions_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'questions';

	// Page object name
	var $PageObjName = 'questions_edit';

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
	function cquestions_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (questions)
		$GLOBALS["questions"] = new cquestions();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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
	var $sDbMasterFilter;
	var $sDbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $questions;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$questions->id->setQueryStringValue($_GET["id"]);
		if (@$_POST["a_edit"] <> "") {
			$questions->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$questions->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$questions->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$questions->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($questions->id->CurrentValue == "")
			$this->Page_Terminate("questionslist.php"); // Invalid key, return to list
		switch ($questions->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("questionslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$questions->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $questions->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$questions->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$questions->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $questions;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $questions;
		$questions->id->setFormValue($objForm->GetValue("x_id"));
		$questions->idLevel->setFormValue($objForm->GetValue("x_idLevel"));
		$questions->Question->setFormValue($objForm->GetValue("x_Question"));
		$questions->caseA->setFormValue($objForm->GetValue("x_caseA"));
		$questions->caseB->setFormValue($objForm->GetValue("x_caseB"));
		$questions->caseC->setFormValue($objForm->GetValue("x_caseC"));
		$questions->caseD->setFormValue($objForm->GetValue("x_caseD"));
		$questions->trueCase->setFormValue($objForm->GetValue("x_trueCase"));
		$questions->Money->setFormValue($objForm->GetValue("x_Money"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $questions;
		$this->LoadRow();
		$questions->id->CurrentValue = $questions->id->FormValue;
		$questions->idLevel->CurrentValue = $questions->idLevel->FormValue;
		$questions->Question->CurrentValue = $questions->Question->FormValue;
		$questions->caseA->CurrentValue = $questions->caseA->FormValue;
		$questions->caseB->CurrentValue = $questions->caseB->FormValue;
		$questions->caseC->CurrentValue = $questions->caseC->FormValue;
		$questions->caseD->CurrentValue = $questions->caseD->FormValue;
		$questions->trueCase->CurrentValue = $questions->trueCase->FormValue;
		$questions->Money->CurrentValue = $questions->Money->FormValue;
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
		} elseif ($questions->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$questions->id->EditCustomAttributes = "";
			$questions->id->EditValue = $questions->id->CurrentValue;
			$questions->id->CssStyle = "";
			$questions->id->CssClass = "";
			$questions->id->ViewCustomAttributes = "";

			// idLevel
			$questions->idLevel->EditCustomAttributes = "";
			$questions->idLevel->EditValue = ew_HtmlEncode($questions->idLevel->CurrentValue);

			// Question
			$questions->Question->EditCustomAttributes = "";
			$questions->Question->EditValue = ew_HtmlEncode($questions->Question->CurrentValue);

			// caseA
			$questions->caseA->EditCustomAttributes = "";
			$questions->caseA->EditValue = ew_HtmlEncode($questions->caseA->CurrentValue);

			// caseB
			$questions->caseB->EditCustomAttributes = "";
			$questions->caseB->EditValue = ew_HtmlEncode($questions->caseB->CurrentValue);

			// caseC
			$questions->caseC->EditCustomAttributes = "";
			$questions->caseC->EditValue = ew_HtmlEncode($questions->caseC->CurrentValue);

			// caseD
			$questions->caseD->EditCustomAttributes = "";
			$questions->caseD->EditValue = ew_HtmlEncode($questions->caseD->CurrentValue);

			// trueCase
			$questions->trueCase->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("1", "1");
			$arwrk[] = array("2", "2");
			$arwrk[] = array("3", "3");
			$arwrk[] = array("4", "4");
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$questions->trueCase->EditValue = $arwrk;

			// Money
			$questions->Money->EditCustomAttributes = "";
			$questions->Money->EditValue = ew_HtmlEncode($questions->Money->CurrentValue);

			// Edit refer script
			// id

			$questions->id->HrefValue = "";

			// idLevel
			$questions->idLevel->HrefValue = "";

			// Question
			$questions->Question->HrefValue = "";

			// caseA
			$questions->caseA->HrefValue = "";

			// caseB
			$questions->caseB->HrefValue = "";

			// caseC
			$questions->caseC->HrefValue = "";

			// caseD
			$questions->caseD->HrefValue = "";

			// trueCase
			$questions->trueCase->HrefValue = "";

			// Money
			$questions->Money->HrefValue = "";
		}

		// Call Row Rendered event
		if ($questions->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$questions->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $questions;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($questions->idLevel->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $questions->idLevel->FldErrMsg();
		}
		if (!ew_CheckInteger($questions->Money->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $questions->Money->FldErrMsg();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $questions;
		$sFilter = $questions->KeyFilter();
		$questions->CurrentFilter = $sFilter;
		$sSql = $questions->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// idLevel
			$questions->idLevel->SetDbValueDef($rsnew, $questions->idLevel->CurrentValue, NULL, FALSE);

			// Question
			$questions->Question->SetDbValueDef($rsnew, $questions->Question->CurrentValue, NULL, FALSE);

			// caseA
			$questions->caseA->SetDbValueDef($rsnew, $questions->caseA->CurrentValue, NULL, FALSE);

			// caseB
			$questions->caseB->SetDbValueDef($rsnew, $questions->caseB->CurrentValue, NULL, FALSE);

			// caseC
			$questions->caseC->SetDbValueDef($rsnew, $questions->caseC->CurrentValue, NULL, FALSE);

			// caseD
			$questions->caseD->SetDbValueDef($rsnew, $questions->caseD->CurrentValue, NULL, FALSE);

			// trueCase
			$questions->trueCase->SetDbValueDef($rsnew, $questions->trueCase->CurrentValue, NULL, FALSE);

			// Money
			$questions->Money->SetDbValueDef($rsnew, $questions->Money->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $questions->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($questions->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($questions->CancelMessage <> "") {
					$this->setMessage($questions->CancelMessage);
					$questions->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$questions->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
}
?>

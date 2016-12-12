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
$system_message_edit = new csystem_message_edit();
$Page =& $system_message_edit;

// Page init
$system_message_edit->Page_Init();

// Page main
$system_message_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var system_message_edit = new ew_Page("system_message_edit");

// page properties
system_message_edit.PageID = "edit"; // page ID
system_message_edit.FormID = "fsystem_messageedit"; // form ID
var EW_PAGE_ID = system_message_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
system_message_edit.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($system_message->status->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_bonus"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($system_message->bonus->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_url"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($system_message->url->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_cp"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($system_message->cp->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_date_begin"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($system_message->date_begin->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_date_begin"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($system_message->date_begin->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_date_end"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($system_message->date_end->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_date_end"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($system_message->date_end->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_date_created"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($system_message->date_created->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_date_created"];
		if (elm && !ew_CheckDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($system_message->date_created->FldErrMsg()) ?>");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
system_message_edit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
system_message_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
system_message_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $system_message->TableCaption() ?><br><br>
<a href="<?php echo $system_message->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$system_message_edit->ShowMessage();
?>
<form name="fsystem_messageedit" id="fsystem_messageedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return system_message_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="system_message">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($system_message->id->Visible) { // id ?>
	<tr<?php echo $system_message->id->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->id->FldCaption() ?></td>
		<td<?php echo $system_message->id->CellAttributes() ?>><span id="el_id">
<div<?php echo $system_message->id->ViewAttributes() ?>><?php echo $system_message->id->EditValue ?></div><input type="hidden" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($system_message->id->CurrentValue) ?>">
</span><?php echo $system_message->id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->content->Visible) { // content ?>
	<tr<?php echo $system_message->content->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->content->FldCaption() ?></td>
		<td<?php echo $system_message->content->CellAttributes() ?>><span id="el_content">
<textarea name="x_content" id="x_content" title="<?php echo $system_message->content->FldTitle() ?>" cols="35" rows="4"<?php echo $system_message->content->EditAttributes() ?>><?php echo $system_message->content->EditValue ?></textarea>
</span><?php echo $system_message->content->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->status->Visible) { // status ?>
	<tr<?php echo $system_message->status->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->status->CellAttributes() ?>><span id="el_status">
<input type="text" name="x_status" id="x_status" title="<?php echo $system_message->status->FldTitle() ?>" size="30" value="<?php echo $system_message->status->EditValue ?>"<?php echo $system_message->status->EditAttributes() ?>>
</span><?php echo $system_message->status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->message_type->Visible) { // message_type ?>
	<tr<?php echo $system_message->message_type->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->message_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->message_type->CellAttributes() ?>><span id="el_message_type">
<select id="x_message_type" name="x_message_type" title="<?php echo $system_message->message_type->FldTitle() ?>"<?php echo $system_message->message_type->EditAttributes() ?>>
<?php
if (is_array($system_message->message_type->EditValue)) {
	$arwrk = $system_message->message_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($system_message->message_type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $system_message->message_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->bonus->Visible) { // bonus ?>
	<tr<?php echo $system_message->bonus->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->bonus->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->bonus->CellAttributes() ?>><span id="el_bonus">
<input type="text" name="x_bonus" id="x_bonus" title="<?php echo $system_message->bonus->FldTitle() ?>" size="30" value="<?php echo $system_message->bonus->EditValue ?>"<?php echo $system_message->bonus->EditAttributes() ?>>
</span><?php echo $system_message->bonus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->url->Visible) { // url ?>
	<tr<?php echo $system_message->url->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->url->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->url->CellAttributes() ?>><span id="el_url">
<textarea name="x_url" id="x_url" title="<?php echo $system_message->url->FldTitle() ?>" cols="35" rows="4"<?php echo $system_message->url->EditAttributes() ?>><?php echo $system_message->url->EditValue ?></textarea>
</span><?php echo $system_message->url->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->cp->Visible) { // cp ?>
	<tr<?php echo $system_message->cp->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->cp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->cp->CellAttributes() ?>><span id="el_cp">
<textarea name="x_cp" id="x_cp" title="<?php echo $system_message->cp->FldTitle() ?>" cols="35" rows="4"<?php echo $system_message->cp->EditAttributes() ?>><?php echo $system_message->cp->EditValue ?></textarea>
</span><?php echo $system_message->cp->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->date_begin->Visible) { // date_begin ?>
	<tr<?php echo $system_message->date_begin->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->date_begin->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->date_begin->CellAttributes() ?>><span id="el_date_begin">
<input type="text" name="x_date_begin" id="x_date_begin" title="<?php echo $system_message->date_begin->FldTitle() ?>" value="<?php echo $system_message->date_begin->EditValue ?>"<?php echo $system_message->date_begin->EditAttributes() ?>>
</span><?php echo $system_message->date_begin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->date_end->Visible) { // date_end ?>
	<tr<?php echo $system_message->date_end->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->date_end->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->date_end->CellAttributes() ?>><span id="el_date_end">
<input type="text" name="x_date_end" id="x_date_end" title="<?php echo $system_message->date_end->FldTitle() ?>" value="<?php echo $system_message->date_end->EditValue ?>"<?php echo $system_message->date_end->EditAttributes() ?>>
</span><?php echo $system_message->date_end->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($system_message->date_created->Visible) { // date_created ?>
	<tr<?php echo $system_message->date_created->RowAttributes ?>>
		<td class="ewTableHeader"><?php echo $system_message->date_created->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td>
		<td<?php echo $system_message->date_created->CellAttributes() ?>><span id="el_date_created">
<input type="text" name="x_date_created" id="x_date_created" title="<?php echo $system_message->date_created->FldTitle() ?>" value="<?php echo $system_message->date_created->EditValue ?>"<?php echo $system_message->date_created->EditAttributes() ?>>
</span><?php echo $system_message->date_created->CustomMsg ?></td>
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
$system_message_edit->Page_Terminate();
?>
<?php

//
// Page class
//
class csystem_message_edit {

	// Page ID
	var $PageID = 'edit';

	// Table name
	var $TableName = 'system_message';

	// Page object name
	var $PageObjName = 'system_message_edit';

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
	function csystem_message_edit() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (system_message)
		$GLOBALS["system_message"] = new csystem_message();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		global $objForm, $Language, $gsFormError, $system_message;

		// Load key from QueryString
		if (@$_GET["id"] <> "")
			$system_message->id->setQueryStringValue($_GET["id"]);
		if (@$_POST["a_edit"] <> "") {
			$system_message->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$system_message->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$system_message->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		} else {
			$system_message->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($system_message->id->CurrentValue == "")
			$this->Page_Terminate("system_messagelist.php"); // Invalid key, return to list
		switch ($system_message->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("system_messagelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$system_message->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $system_message->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$system_message->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$system_message->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $system_message;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $system_message;
		$system_message->id->setFormValue($objForm->GetValue("x_id"));
		$system_message->content->setFormValue($objForm->GetValue("x_content"));
		$system_message->status->setFormValue($objForm->GetValue("x_status"));
		$system_message->message_type->setFormValue($objForm->GetValue("x_message_type"));
		$system_message->bonus->setFormValue($objForm->GetValue("x_bonus"));
		$system_message->url->setFormValue($objForm->GetValue("x_url"));
		$system_message->cp->setFormValue($objForm->GetValue("x_cp"));
		$system_message->date_begin->setFormValue($objForm->GetValue("x_date_begin"));
		$system_message->date_begin->CurrentValue = ew_UnFormatDateTime($system_message->date_begin->CurrentValue, 5);
		$system_message->date_end->setFormValue($objForm->GetValue("x_date_end"));
		$system_message->date_end->CurrentValue = ew_UnFormatDateTime($system_message->date_end->CurrentValue, 5);
		$system_message->date_created->setFormValue($objForm->GetValue("x_date_created"));
		$system_message->date_created->CurrentValue = ew_UnFormatDateTime($system_message->date_created->CurrentValue, 5);
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $system_message;
		$this->LoadRow();
		$system_message->id->CurrentValue = $system_message->id->FormValue;
		$system_message->content->CurrentValue = $system_message->content->FormValue;
		$system_message->status->CurrentValue = $system_message->status->FormValue;
		$system_message->message_type->CurrentValue = $system_message->message_type->FormValue;
		$system_message->bonus->CurrentValue = $system_message->bonus->FormValue;
		$system_message->url->CurrentValue = $system_message->url->FormValue;
		$system_message->cp->CurrentValue = $system_message->cp->FormValue;
		$system_message->date_begin->CurrentValue = $system_message->date_begin->FormValue;
		$system_message->date_begin->CurrentValue = ew_UnFormatDateTime($system_message->date_begin->CurrentValue, 5);
		$system_message->date_end->CurrentValue = $system_message->date_end->FormValue;
		$system_message->date_end->CurrentValue = ew_UnFormatDateTime($system_message->date_end->CurrentValue, 5);
		$system_message->date_created->CurrentValue = $system_message->date_created->FormValue;
		$system_message->date_created->CurrentValue = ew_UnFormatDateTime($system_message->date_created->CurrentValue, 5);
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
		} elseif ($system_message->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$system_message->id->EditCustomAttributes = "";
			$system_message->id->EditValue = $system_message->id->CurrentValue;
			$system_message->id->CssStyle = "";
			$system_message->id->CssClass = "";
			$system_message->id->ViewCustomAttributes = "";

			// content
			$system_message->content->EditCustomAttributes = "";
			$system_message->content->EditValue = ew_HtmlEncode($system_message->content->CurrentValue);

			// status
			$system_message->status->EditCustomAttributes = "";
			$system_message->status->EditValue = ew_HtmlEncode($system_message->status->CurrentValue);

			// message_type
			$system_message->message_type->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("0", "0");
			$arwrk[] = array("1", "1");
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$system_message->message_type->EditValue = $arwrk;

			// bonus
			$system_message->bonus->EditCustomAttributes = "";
			$system_message->bonus->EditValue = ew_HtmlEncode($system_message->bonus->CurrentValue);

			// url
			$system_message->url->EditCustomAttributes = "";
			$system_message->url->EditValue = ew_HtmlEncode($system_message->url->CurrentValue);

			// cp
			$system_message->cp->EditCustomAttributes = "";
			$system_message->cp->EditValue = ew_HtmlEncode($system_message->cp->CurrentValue);

			// date_begin
			$system_message->date_begin->EditCustomAttributes = "";
			$system_message->date_begin->EditValue = ew_HtmlEncode(ew_FormatDateTime($system_message->date_begin->CurrentValue, 5));

			// date_end
			$system_message->date_end->EditCustomAttributes = "";
			$system_message->date_end->EditValue = ew_HtmlEncode(ew_FormatDateTime($system_message->date_end->CurrentValue, 5));

			// date_created
			$system_message->date_created->EditCustomAttributes = "";
			$system_message->date_created->EditValue = ew_HtmlEncode(ew_FormatDateTime($system_message->date_created->CurrentValue, 5));

			// Edit refer script
			// id

			$system_message->id->HrefValue = "";

			// content
			$system_message->content->HrefValue = "";

			// status
			$system_message->status->HrefValue = "";

			// message_type
			$system_message->message_type->HrefValue = "";

			// bonus
			$system_message->bonus->HrefValue = "";

			// url
			$system_message->url->HrefValue = "";

			// cp
			$system_message->cp->HrefValue = "";

			// date_begin
			$system_message->date_begin->HrefValue = "";

			// date_end
			$system_message->date_end->HrefValue = "";

			// date_created
			$system_message->date_created->HrefValue = "";
		}

		// Call Row Rendered event
		if ($system_message->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$system_message->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $system_message;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($system_message->status->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $system_message->status->FldErrMsg();
		}
		if (!ew_CheckInteger($system_message->bonus->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $system_message->bonus->FldErrMsg();
		}
		if (!is_null($system_message->url->FormValue) && $system_message->url->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $system_message->url->FldCaption();
		}
		if (!is_null($system_message->cp->FormValue) && $system_message->cp->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $system_message->cp->FldCaption();
		}
		if (!is_null($system_message->date_begin->FormValue) && $system_message->date_begin->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $system_message->date_begin->FldCaption();
		}
		if (!ew_CheckDate($system_message->date_begin->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $system_message->date_begin->FldErrMsg();
		}
		if (!is_null($system_message->date_end->FormValue) && $system_message->date_end->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $system_message->date_end->FldCaption();
		}
		if (!ew_CheckDate($system_message->date_end->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $system_message->date_end->FldErrMsg();
		}
		if (!is_null($system_message->date_created->FormValue) && $system_message->date_created->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $Language->Phrase("EnterRequiredField") . " - " . $system_message->date_created->FldCaption();
		}
		if (!ew_CheckDate($system_message->date_created->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $system_message->date_created->FldErrMsg();
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
		global $conn, $Security, $Language, $system_message;
		$sFilter = $system_message->KeyFilter();
		$system_message->CurrentFilter = $sFilter;
		$sSql = $system_message->SQL();
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

			// content
			$system_message->content->SetDbValueDef($rsnew, $system_message->content->CurrentValue, NULL, FALSE);

			// status
			$system_message->status->SetDbValueDef($rsnew, $system_message->status->CurrentValue, 0, FALSE);

			// message_type
			$system_message->message_type->SetDbValueDef($rsnew, $system_message->message_type->CurrentValue, 0, FALSE);

			// bonus
			$system_message->bonus->SetDbValueDef($rsnew, $system_message->bonus->CurrentValue, 0, FALSE);

			// url
			$system_message->url->SetDbValueDef($rsnew, $system_message->url->CurrentValue, "", FALSE);

			// cp
			$system_message->cp->SetDbValueDef($rsnew, $system_message->cp->CurrentValue, "", FALSE);

			// date_begin
			$system_message->date_begin->SetDbValueDef($rsnew, ew_UnFormatDateTime($system_message->date_begin->CurrentValue, 5, FALSE), ew_CurrentDate());

			// date_end
			$system_message->date_end->SetDbValueDef($rsnew, ew_UnFormatDateTime($system_message->date_end->CurrentValue, 5, FALSE), ew_CurrentDate());

			// date_created
			$system_message->date_created->SetDbValueDef($rsnew, ew_UnFormatDateTime($system_message->date_created->CurrentValue, 5, FALSE), ew_CurrentDate());

			// Call Row Updating event
			$bUpdateRow = $system_message->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($system_message->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($system_message->CancelMessage <> "") {
					$this->setMessage($system_message->CancelMessage);
					$system_message->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$system_message->Row_Updated($rsold, $rsnew);
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

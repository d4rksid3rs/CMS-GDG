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
$system_message_delete = new csystem_message_delete();
$Page =& $system_message_delete;

// Page init
$system_message_delete->Page_Init();

// Page main
$system_message_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var system_message_delete = new ew_Page("system_message_delete");

// page properties
system_message_delete.PageID = "delete"; // page ID
system_message_delete.FormID = "fsystem_messagedelete"; // form ID
var EW_PAGE_ID = system_message_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
system_message_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
system_message_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
system_message_delete.ValidateRequired = false; // no JavaScript validation
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
<?php

// Load records for display
if ($rs = $system_message_delete->LoadRecordset())
	$system_message_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($system_message_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$system_message_delete->Page_Terminate("system_messagelist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $system_message->TableCaption() ?><br><br>
<a href="<?php echo $system_message->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$system_message_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="system_message">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($system_message_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $system_message->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $system_message->id->FldCaption() ?></td>
		<td valign="top"><?php echo $system_message->content->FldCaption() ?></td>
		<td valign="top"><?php echo $system_message->status->FldCaption() ?></td>
		<td valign="top"><?php echo $system_message->message_type->FldCaption() ?></td>
		<td valign="top"><?php echo $system_message->date_end->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$system_message_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$system_message_delete->lRecCnt++;

	// Set row properties
	$system_message->CssClass = "";
	$system_message->CssStyle = "";
	$system_message->RowAttrs = array();
	$system_message->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$system_message_delete->LoadRowValues($rs);

	// Render row
	$system_message_delete->RenderRow();
?>
	<tr<?php echo $system_message->RowAttributes() ?>>
		<td<?php echo $system_message->id->CellAttributes() ?>>
<div<?php echo $system_message->id->ViewAttributes() ?>><?php echo $system_message->id->ListViewValue() ?></div></td>
		<td<?php echo $system_message->content->CellAttributes() ?>>
<div<?php echo $system_message->content->ViewAttributes() ?>><?php echo $system_message->content->ListViewValue() ?></div></td>
		<td<?php echo $system_message->status->CellAttributes() ?>>
<div<?php echo $system_message->status->ViewAttributes() ?>><?php echo $system_message->status->ListViewValue() ?></div></td>
		<td<?php echo $system_message->message_type->CellAttributes() ?>>
<div<?php echo $system_message->message_type->ViewAttributes() ?>><?php echo $system_message->message_type->ListViewValue() ?></div></td>
		<td<?php echo $system_message->date_end->CellAttributes() ?>>
<div<?php echo $system_message->date_end->ViewAttributes() ?>><?php echo $system_message->date_end->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$system_message_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class csystem_message_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'system_message';

	// Page object name
	var $PageObjName = 'system_message_delete';

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
	function csystem_message_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (system_message)
		$GLOBALS["system_message"] = new csystem_message();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $lTotalRecs = 0;
	var $lRecCnt;
	var $arRecKeys = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $system_message;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id"] <> "") {
			$system_message->id->setQueryStringValue($_GET["id"]);
			if (!is_numeric($system_message->id->QueryStringValue))
				$this->Page_Terminate("system_messagelist.php"); // Prevent SQL injection, exit
			$sKey .= $system_message->id->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("system_messagelist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("system_messagelist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in system_message class, system_messageinfo.php

		$system_message->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$system_message->CurrentAction = $_POST["a_delete"];
		} else {
			$system_message->CurrentAction = "I"; // Display record
		}
		switch ($system_message->CurrentAction) {
			case "D": // Delete
				$system_message->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($system_message->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $system_message;
		$DeleteRows = TRUE;
		$sWrkFilter = $system_message->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in system_message class, system_messageinfo.php

		$system_message->CurrentFilter = $sWrkFilter;
		$sSql = $system_message->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $system_message->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($system_message->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($system_message->CancelMessage <> "") {
				$this->setMessage($system_message->CancelMessage);
				$system_message->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$system_message->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
}
?>

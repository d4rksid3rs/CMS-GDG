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
$questions_delete = new cquestions_delete();
$Page =& $questions_delete;

// Page init
$questions_delete->Page_Init();

// Page main
$questions_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var questions_delete = new ew_Page("questions_delete");

// page properties
questions_delete.PageID = "delete"; // page ID
questions_delete.FormID = "fquestionsdelete"; // form ID
var EW_PAGE_ID = questions_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
questions_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
questions_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
questions_delete.ValidateRequired = false; // no JavaScript validation
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
if ($rs = $questions_delete->LoadRecordset())
	$questions_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($questions_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$questions_delete->Page_Terminate("questionslist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $questions->TableCaption() ?><br><br>
<a href="<?php echo $questions->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$questions_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="questions">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($questions_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $questions->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $questions->id->FldCaption() ?></td>
		<td valign="top"><?php echo $questions->Question->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$questions_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$questions_delete->lRecCnt++;

	// Set row properties
	$questions->CssClass = "";
	$questions->CssStyle = "";
	$questions->RowAttrs = array();
	$questions->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$questions_delete->LoadRowValues($rs);

	// Render row
	$questions_delete->RenderRow();
?>
	<tr<?php echo $questions->RowAttributes() ?>>
		<td<?php echo $questions->id->CellAttributes() ?>>
<div<?php echo $questions->id->ViewAttributes() ?>><?php echo $questions->id->ListViewValue() ?></div></td>
		<td<?php echo $questions->Question->CellAttributes() ?>>
<div<?php echo $questions->Question->ViewAttributes() ?>><?php echo $questions->Question->ListViewValue() ?></div></td>
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
$questions_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class cquestions_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'questions';

	// Page object name
	var $PageObjName = 'questions_delete';

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
	function cquestions_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (questions)
		$GLOBALS["questions"] = new cquestions();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $lTotalRecs = 0;
	var $lRecCnt;
	var $arRecKeys = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $questions;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id"] <> "") {
			$questions->id->setQueryStringValue($_GET["id"]);
			if (!is_numeric($questions->id->QueryStringValue))
				$this->Page_Terminate("questionslist.php"); // Prevent SQL injection, exit
			$sKey .= $questions->id->QueryStringValue;
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
			$this->Page_Terminate("questionslist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("questionslist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in questions class, questionsinfo.php

		$questions->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$questions->CurrentAction = $_POST["a_delete"];
		} else {
			$questions->CurrentAction = "I"; // Display record
		}
		switch ($questions->CurrentAction) {
			case "D": // Delete
				$questions->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($questions->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $questions;
		$DeleteRows = TRUE;
		$sWrkFilter = $questions->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in questions class, questionsinfo.php

		$questions->CurrentFilter = $sWrkFilter;
		$sSql = $questions->SQL();
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
				$DeleteRows = $questions->Row_Deleting($row);
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
				$DeleteRows = $conn->Execute($questions->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($questions->CancelMessage <> "") {
				$this->setMessage($questions->CancelMessage);
				$questions->CancelMessage = "";
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
				$questions->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
}
?>

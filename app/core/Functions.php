<?php

function getComponent($file, $data = array()) {

	$docroot = $_SERVER['DOCUMENT_ROOT'];
	$dirpath = $docroot."/app/views/components/";

	$filepath = $dirpath.$file.".php";

	return require $filepath;

}

function getShared($file, $data = array()) {

	$docroot = $_SERVER['DOCUMENT_ROOT'];
	$dirpath = $docroot."/app/views/shared/";

	$filepath = $dirpath.$file.".php";

	return require_once $filepath;
}

function getHeader($data = array()) {

	return getShared("header", $data);
}

function getFooter($data = array()) {

	return getShared("footer", $data);
}

function isEditableAttributes($schema, $name) {
  $isLoggedIn = true;
  if ($isLoggedIn) {
    $dataString = 'data-editable data-id="' . $name . '"';
    foreach ($schema as $key => $value) {
      if ($key !== 'default' && $key !== 'class') {
        $dataString = $dataString . " data-" . $key . "='" . $value . "'";
      }
    }
    return $dataString;
  }
  return;
}

function getTagClass($schema) {
  if ($schema['class']) {
    return 'class="' . $schema['class'] . '"';
  }
  return;
}

function buildLink($schema, $pageData, $page) {
  $link = "";
  if (!empty($pageData[$schema['action_text']['name']])) {
    $content = $pageData[$schema['action_text']['name']];
  } elseif (!empty($schema['action_text']['default'])) {
    $content = $schema['action_text']['default'];
  }
  if (!empty($pageData[$schema['action_link']['name']])) {
    $link = $pageData[$schema['action_link']['name']];
  } elseif (!empty($schema['action_link']['default'])) {
    $link = $schema['action_link']['default'];
  }
  echo '<input type="hidden" ' . isEditableAttributes($schema['action_link'], $page) . ' value="' . $link. '" />';
  echo '<a href="/'. $link .'" ' . getTagClass($schema) . ' ' . isEditableAttributes($schema['action_text'], $page) . '>'. $content .'</a>';
}

function editableBlock($schema, $tag, $page) {
  $pageData = Editable::getInstance()->getPageData($page)[0];
  $content = "";

  switch ($schema['type']) {
    case 'link':
      buildLInk($schema, $pageData, $page);
      break;
    default:
      if (!empty($pageData[$schema['name']])) {
        $content = $pageData[$schema['name']];
      } elseif (!empty($schema['default'])) {
        $content = $schema['default'];
      }
      echo "<" . $tag . " " . getTagClass($schema) . " " . isEditableAttributes($schema, $page) . ">" . $content . "</" . $tag . ">";
      break;
  }
}

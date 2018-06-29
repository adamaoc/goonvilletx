<?php

class PagesModel
{
  public function getPageData($page)
  {
    $pageFile = "./data/" . $page . ".csv";
    $pageArr = array(
      'fields' => array(),
      'pageData' => array()
    );
    $row = 1;
    if (($handle = fopen($pageFile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row === 1) {
                foreach ($data as $value) {
                  array_push($pageArr['fields'], $value);
                }
            } else {
              foreach ($data as $key => $value) {
                $field = $pageArr['fields'][$key];
                $id = $row - 2;
                $pageArr['pageData'][$id][$field] = $value;
              }
            }
            $row++;
        }
        fclose($handle);
    }
    return $pageArr['pageData'];
  }

  public function updatePageData($page, $data)
  {
    $pageData = $this->getPageData($page);

    // update page data //
    foreach ($data as $key => $value) {
      $pageData[0][$key] = $value;
    }
    $pageData[0]['updated'] = date("Y-m-d");

    // save as csv //
    $row = 1;
    $saveData = array(
      'labels' => array(),
      'values' => array()
    );
    foreach ($pageData[0] as $key => $value) {
      array_push($saveData['labels'], $key);
      array_push($saveData['values'], $value);
    }
    $pageFile = "./data/" . $page . ".csv";
    $fp = fopen($pageFile, 'w');
    foreach ($saveData as $row) {
      fputcsv($fp, $row);
    }
    fclose($fp);

    return $this->getPageData($page);
  }
}

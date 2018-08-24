<?php
// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

session_start();


function initializeAnalytics()
{
    // Creates and returns the Analytics Reporting service object.

    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = __DIR__ . '/client_secrets.json';

    // Create and configure a new client object.
    $client = new Google_Client();
    // $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(Google_Service_Analytics::ANALYTICS_READONLY);

    $analytics = new Google_Service_AnalyticsReporting($client);

    return $analytics;
}

// Load the Google API PHP Client Library.
function getReport1($analytics) {
  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "162575063";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("today");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:pageviews");
  $sessions->setAlias("Kunjungan Hari Ini");
  
  $browser = new Google_Service_AnalyticsReporting_Dimension();
  $browser->setName("ga:hostname");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getReport2($analytics) {
  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "162575063";

  $awal = date("Y-m-01");    
  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($awal);
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:pageviews");
  $sessions->setAlias("Kunjungan Bulan ini");

  $browser = new Google_Service_AnalyticsReporting_Dimension();
  $browser->setName("ga:hostname");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function getReport3($analytics) {
  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "162575063";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("yesterday");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:pageviews");
  $sessions->setAlias("Kunjungan Minggu Ini");

  $browser = new Google_Service_AnalyticsReporting_Dimension();
  $browser->setName("ga:hostname");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}

function printResults($reports) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    $ref = $_SESSION['referal'];
    

    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[ $rowIndex ];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
        for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
            //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
            if ($dimensions[$i] == $ref){
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                for ($j = 0; $j < count($metrics); $j++) {
                    $values = $metrics[$j]->getValues();
                    for ($k = 0; $k < count($values); $k++) {
                      $entry = $metricHeaders[$k];
                      //print($entry->getName() . ": " . $values[$k] . "\n");
                      print($values[$k]);
                    }
                }
            }  
        }
    }
  }
}

$analytics = initializeAnalytics();

// Call the Analytics Reporting API V4.
$response1 = getReport1($analytics);
$response2 = getReport2($analytics);
$response3 = getReport3($analytics);

printResults($response1);
echo "<br>";
printResults($response2);
echo "<br>";
printResults($response3);
echo "<br>";

echo "5";

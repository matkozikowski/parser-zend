<?php

namespace Mkparser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Http\Client;
use Zend\Dom\Query;
use Zend\View\Helper\ServerUrl;
use Zend\Http\Response\Stream;

class MkparserController extends AbstractActionController
{
	const DOM_SEARCH_DOMAIN = 'https://buddyschool.com/search?keyword=';
	const DOM_CONTENT = '.contentLayout .profileMain';
	private $searchResults = [];

	public function indexAction(){}

 	/**
	* Handle for ajax request, necessary to create results file txt.
	*
	* @return JsonModel
	*/
	public function searchAction()
	{
		$data = [];
		$status = false;
		$request = $this->getRequest();
		$searchValue = $request->getPost('value');

		$queryUrl = $this->prepareQueryUrl($searchValue);

		if ( $this->setQueryDom($queryUrl) ) {
			$status = true;
			$result = $this->getFirstQueryDom();
			$this->saveQueryDomFile($result);
		}


		if ($request->isXmlHttpRequest()) {
			$fileUrl = $this->getBaseUrl() . '/data/profil.txt';
			$fileDownload = $this->getBaseUrl() . '/mkparser/download';
			$fileName = 'Podglad Pliku: '. date('H:m:s d-m-Y');
			$data = ['status' => $status, 'url' => $fileUrl, 'file_name' => $fileName, 'url_download' => $fileDownload];
		}

		return new JsonModel($data);
	}

	/**
 	* Create Output txt file with searched values.
 	*
 	* @return Response
 	*/
	public function downloadAction()
	{
		$fileUrl = $this->getBaseUrl() . '/data/profil.txt';
    	$fileContents = file_get_contents($fileUrl);

    	$response = $this->getResponse();
    	$response->setContent($fileContents);

    	$headers = $response->getHeaders();
    	$headers->clearHeaders()
        ->addHeaderLine('Content-Type', 'whatever your content type is')
        ->addHeaderLine('Content-Disposition', 'attachment; filename="profil.txt"')
        ->addHeaderLine('Content-Length', strlen($fileContents));

    	return $this->response;
	}

	/**
 	* Set search results from DOM Client.
	*
 	* @param string $search value from users search text
	*
 	* @return boolean
 	*/
	private function setQueryDom($search)
	{
		$client = new Client($search);

		$result = $client->send();
		$body = $result->getBody();

		$dom = new Query($body);
		$results = $dom->execute(self::DOM_CONTENT);
		$count = count($results);
		foreach ($results as $key => $result ) {
			$resultText = preg_replace('/^[ \t]*[\r\n]+/m', '', $result->textContent);
			array_push($this->searchResults, $resultText);
		}

		if (empty($this->searchResults)) {
			return false;
		}
		return true;
	}

	/**
 	* Prepare URL to Client
	*
 	* @param string $searchText value from users search text.
	*
 	* @return string
 	*/
	private function prepareQueryUrl($searchText)
	{
		return self::DOM_SEARCH_DOMAIN . urlencode($searchText);
	}

	/**
 	* Take the first value from searched data DOM.
	*
	*
 	* @return array()
 	*/
	private function getFirstQueryDom()
	{
		reset($this->searchResults);
		return current($this->searchResults);
	}

	/**
 	* Save data into file profil.txt. Located in public/data.
	*
 	* @param string $value value from search
	*
 	* @return void
 	*/
	private function saveQueryDomFile($value)
	{
		$file = getcwd() . '/public/data/profil.txt';
    	file_put_contents($file, $value);
	}

	/**
 	* Get Base Host Url.
	*
	*
 	* @return string
 	*/
	private function getBaseUrl()
	{
		$helper = new ServerUrl();
		return $helper->__invoke(false);
	}

}

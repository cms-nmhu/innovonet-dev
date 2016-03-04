<?php
/*
 *
 */
class Controller_Item extends Ecl_Mvc_Controller {



	public function beforeAction() {
		if ( (false == $this->model('app.allow_anonymous')) && ($this->model('user')->isAnonymous()) ) {
			$this->abort();
			$this->router()->action('index', 'signin');
			return;
		}

		$this->layout()->addBreadcrumb('Items', $this->router()->makeAbsoluteUri('/atoz/'));
	}// /method



	public function actionDownloadfile () {
		$item = $this->model('itemstore')->find($this->param('itemid'));

		$filename = $this->param('filename');

		if ($this->model('user')->isAnonymous()) {
			$this->router()->action('unauthorised', 'error');
			return true;
		}

		if (empty($item)) {
			$this->router()->action('404', 'error');
			return true;
		}

		$this->view()->filename = $this->model('app.upload_root').'/items'. $item->getFilePath() .'/'. $filename;
		$this->view()->render('item_downloadfile');
	}// /method



	public function actionDownloadimage () {
		$item = $this->model('itemstore')->find($this->param('itemid'));

		$filename = $this->param('filename');

		if (empty($item)) {
			$this->router()->action('404', 'error');
			return true;
		}

		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$ext = strtolower($ext);
		$mime_type = Ecl_Helper_Mime::getTypeForExtension($ext);

		$this->view()->filename = $this->model('app.upload_root').'/items'. $item->getFilePath() .'/'. $filename;
		$this->view()->mime_type = $mime_type;
		$this->view()->render('item_downloadimage');
	}// /method



	public function actionIndex() {
		$user = $this->model('user');

		$letter = ucwords( $this->request()->get('letter', 'A') );

		$alphabet = $this->model('itemstore')->findUsedAToZ($user->param('visibility'));
		// If no letter selected, auto-select the first letter with items in
		if ( (!in_array($letter, $alphabet)) && (count($alphabet)>0) ) {
			$letter = ucwords($alphabet[0]);
		}

		$this->view()->letter = $letter;
		$this->view()->alphabet = $alphabet;

		if ('Other' == $letter) {
			$this->view()->items = $this->model('itemstore')->findForManufacturerLetter(null, $user->param('visibility'));
		} else {
			$this->view()->items = $this->model('itemstore')->findForManufacturerLetter($letter, $user->param('visibility'));
		}

		$this->view()->render('atoz_index');
	}// /method



	public function actionView() {
		$item = $this->model('itemstore')->find($this->param('itemid'));

		if (empty($item)) {
			$this->router()->action('404', 'error');
			return true;
		}

		if ( (KC__VISIBILITY_PUBLIC != $item->visibility) && ($this->model('user')->isAnonymous()) ) {
			$this->router()->action('404', 'error');
			return true;
		}

		$this->layout()->addBreadcrumb($item->name, $this->router()->makeAbsoluteUri("/item/{$item->slug}"));

		$this->view()->item = $item;

		$this->view()->render('item_view');
	}// /method



/* --------------------------------------------------------------------------------
 * Private Methods
 */



}// /class
?>
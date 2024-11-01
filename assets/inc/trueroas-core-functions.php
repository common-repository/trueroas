<?php 
class TrueRoas_Events
{
	private $pixelID;

	function __construct()
	{
		try {
			$url = home_url();
			$url = str_replace(array('http://', 'https://'), '', $url);
			$this->pixelID = sanitize_text_field($url);
			$this->init_hooks();
		} catch (Exception $e) {
			// Handle the exception
			error_log('Error occurred while adding action: ' . $e->getMessage());
		}
	}
	private function init_hooks()
	{
		try {
			add_action('woocommerce_new_order', [$this, 'woocommerce_new_order'], $priority = 10, $accepted_args = 2);
		} catch (Exception $e) {
			// Handle the exception
			error_log('Error occurred while adding action: ' . $e->getMessage());
		}
		try {
			add_action('woocommerce_update_order', [$this, 'woocommerce_update_order'], $priority = 10, $accepted_args = 2);
		} catch (Exception $e) {
			// Handle the exception
			error_log('Error occurred while adding action: ' . $e->getMessage());
		}
		// add_action( 'woocommerce_order_status_changed', [$this,'woocommerce_update_order_status'], $priority = 10, $accepted_args = 2 );
	}

	private function get_trueroas_uuid() {
		try {
			$trueroas_cid = isset($_COOKIE['trueroas_cid']) ? $_COOKIE['trueroas_cid'] : '';
			return $trueroas_cid;
		} catch (Exception $e) {
			return "";
		}
	}
	private function call($url, $json)
	{
		try {
      // $trueroas_cid = $_COOKIE['trueroas_cid'] ?? '';
			$trueroas_cid = $this->get_trueroas_uuid();
			//wp_remote_get($url);
			$data = wp_remote_post($url, array(
				'method' => 'POST',
				//'timeout'  => 45,
				'blocking' => false, 
				//'sslverify' => false,
				//'httpversion' => '1.0',
				//'redirection' => 5,
				'data_format' => 'body',
				'headers' => array(
					'Accept' => 'application/json',
					'Content-Type' => 'application/json',
          'X-Trueroas-Cid' => $trueroas_cid
				),
				'body' => $json,
			));
		} catch (Exception $e) {
			// Handle the exception
			error_log('Error occurred while using call call: ' . $e->getMessage());
		}

	}


	public function woocommerce_new_order($order_id, $order){
		try {
		$order_data = $order->get_data();
		$line_items = $order->get_items();
		$items_data = array();
		foreach ($line_items as $item) {
			$product_id = $item->get_product_id();
			$quantity = $item->get_quantity();
			$subtotal = $item->get_subtotal();
			$product = $item->get_product();
			if ($product) {
				$name = $product->get_name();
				$price = $product->get_price();
			} else {
				$name = 'Product Not Found';

				if ($subtotal && $quantity) {
					$price = $subtotal / $quantity;
				} else {
					$price = 0;
				}
			}
			$items_data[] = array(
				'product_id' => $product_id,
				'quantity' => $quantity,
				'subtotal' => $subtotal,
				'name' => $name,
				'price' => $price,
			);
		}
		$order_data['line_items'] = $items_data;
		$order_data['status'] = $order->get_status();
		$json = json_encode($order_data);
		$url = 'https://app.trueroas.io/api/woo/ordercreated?pixel_id=' . $this->pixelID;
		$this->call($url, $json);
	} catch (Exception $e) {
        error_log('Error updating order: ' . $e->getMessage());
    	}
	}
	
	public function woocommerce_update_order(){
		try {
			$args = func_get_args();
			$order_id = isset($args[0]) ? $args[0] : null;
			$order = isset($args[1]) ? $args[1] : null;
			if (!$order_id || !$order) {
				throw new Exception('Missing arguments for woocommerce_update_order function.');
			}
		$order_data = $order->get_data();
		$line_items = $order->get_items();
		$items_data = array();
		foreach ($line_items as $item) {
			$product_id = $item->get_product_id();
			$quantity = $item->get_quantity();
			$subtotal = $item->get_subtotal();
			$product = $item->get_product(); 
			if ($product) {
				$name = $product->get_name();
				$price = $product->get_price();
			} else {
				$name = 'Product Not Found';

				if ($subtotal && $quantity) {
					$price = $subtotal / $quantity;
				} else {
					$price = 0;
				}
			}
			$items_data[] = array(
				'product_id' => $product_id,
				'quantity' => $quantity,
				'subtotal' => $subtotal,
				'name' => $name,
				'price' => $price,
			);
		}
		$order_data['line_items'] = $items_data;
		$order_data['status'] = $order->get_status();
		$json = json_encode($order_data);
		$url = 'https://app.trueroas.io/api/woo/ordercreated?pixel_id=' . $this->pixelID;
		$this->call($url, $json);
	} catch (Exception $e) {

        error_log('Error updating order: ' . $e->getMessage()); 
    	}
	}

	// public function woocommerce_new_order( $order_id, $order){
	// 	$order_data = $order->get_data();
	// 	$json  = json_encode($order_data);
	// 	$url = 'https://app.trueroas.io/api/woo/ordercreated?pixel_id='.$this->pixelID;
	// 	$this->call($url,$json);
	// }
	// public function woocommerce_update_order( $order_id, $order){
	// 	$order_data = $order->get_data();
	// 	$json  = json_encode($order_data);
	// 	$url = 'https://app.trueroas.io/api/woo/ordercreated?pixel_id='.$this->pixelID;
	// 	$this->call($url,$json);
	// }
	
	

}
new TrueRoas_Events();
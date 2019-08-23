<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_new extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $category_list = $this->categoryList();
        
        if (!empty($category_list)) {


            foreach ($category_list as $category_value) {

                if (!empty($category_value['image'])) {

                    if (isset($category_value['image']['src']) && $category_value['image']['src'] != "") {

                        $pathinfo = pathinfo($category_value['image']['src']);

                        if (!empty($pathinfo)) {

                            $image_name = str_replace(' ', '%20', $pathinfo['basename']);
                            $path = 'assets/uploads/category/' . $pathinfo['basename'];
                            $myfile = file_get_contents('https://www.rent4health.com/uploads/product_images/' . $image_name);
                            $uploadfile = file_put_contents($path, $myfile);

                            $category_data['category_image'] = $pathinfo['basename'];
                        }
                    }
                }

                $category_id_check_product = $category_value['id'];

                $category_data['site_id'] = BUY4HEALTHID;
                $category_data['category_name'] = $category_value['name'];
                $category_data['category_description'] = $category_value['description'];
                $category_data['category_tag'] = '';
                $category_data['status'] = 1;

                $check_category_exist = $this->db->select('category_name,id')
                        ->where("category_name", $category_value['name'])
                        ->where("site_id", BUY4HEALTHID)
                        ->get('category')->row_array();

                if (empty($check_category_exist)) {
                    $this->db->insert('category', $category_data);
                    $category_id = $this->db->insert_id();
                } else {
                    $category_id = $check_category_exist['id'];
                    $this->db->where('id', $check_category_exist['id']);
                    $this->db->update('category', $category_data);
                }
            }
        }


        /*         * ***** For Product ****** */

        $products_list = $this->getProducts();

        if (!empty($products_list)) {

            foreach ($products_list as $product) {

                foreach ($product as $product_key => $product_value) {

                    $category_name = isset($product_value['categories'][0]['name']) ? $product_value['categories'][0]['name'] : "";

                    $categoryId = $this->db->select('*')
                                    ->from('category')
                                    ->where("category_name", $category_name)
                                    ->where("site_id", BUY4HEALTHID)
                                    ->get()->row_array();

                    if (empty($categoryId)) {
                        $category_data['site_id'] = BUY4HEALTHID;
                        $category_data['category_name'] = $category_name;
                        $category_data['category_description'] = '';
                        $category_data['category_tag'] = '';
                        $category_data['status'] = 1;

                        $this->db->insert('category', $category_data);
                        $category_id = $this->db->insert_id();
                    } else {
                        $category_id = $categoryId['id'];
                    }

                    $b4hcheck_product_exist = $this->db->select('p.product_code,p.id')
                                    ->from('product as p')
                                    ->join('category c', 'c.id = p.category', 'left')
                                    ->where("p.product_code", $product_value['sku'])
                                    ->where("p.product_name", $product_value['name'])
                                    ->where("p.site_id", BUY4HEALTHID)
                                    ->where('c.category_name', $category_name)
                                    ->get()->row_array();

                    $check_size_type = $this->db->select('*')
                                    ->where('size_type', $product_value['type'])
                                    ->get('size_type')->row_array();


                    $product_data['site_id'] = BUY4HEALTHID;
                    $product_data['product_type'] = BUY;
                    $product_data['product_code'] = isset($product_value['sku']) ? $product_value['sku'] : "";
                    $product_data['product_name'] = isset($product_value['name']) ? $product_value['name'] : "";
                    $product_data['category'] = $category_id;
                    $product_data['product_description'] = isset($product_value['description']) ? $product_value['description'] : "";
                    $product_data['product_info'] = isset($product_value['short_description']) ? $product_value['short_description'] : "";
                    $product_data['product_weight'] = isset($product_value['weight']) ? $product_value['weight'] : "";
                    $product_data['product_tags'] = '';
                    $product_data['size_type'] = isset($check_size_type['id']) ? $check_size_type['id'] : 0;
                    $product_data['avg_rating'] = isset($product_value['average_rating']) ? $product_value['average_rating'] : "";
                    $product_data['avg_sale_price'] = isset($product_value['sale_price']) ? $product_value['sale_price'] : "";
                    $product_data['status'] = 1;

                    if (!empty($b4hcheck_product_exist)) {
                        $b4hproduct_id = $b4hcheck_product_exist['id'];
                        $this->db->where('id', $b4hcheck_product_exist['id']);
                        $this->db->update('product', $product_data);
                    } else {
                        $this->db->insert('product', $product_data);
                        $b4hproduct_id = $this->db->insert_id();
                    }

                    /*                     * ***** For Product Images ****** */

                    if (!empty($product_value['images'])) {

                        foreach ($product_value['images'] as $b4hproductImg_value) {

                            $image_name = str_replace(' ', '%20', basename($b4hproductImg_value['src']));

                            $b4hcheck_productImg_exist = $this->db->select('product_image,id')
                                            ->where("product_image", $image_name)
                                            ->where('product_id', $b4hproduct_id)
                                            ->get('product_images')->row_array();


                            if (isset($b4hproductImg_value['src']) && $b4hproductImg_value['src'] != "") {


                                $path = 'assets/uploads/product/' . $image_name;
                                $myfile = file_get_contents($b4hproductImg_value['src']);

                                $uploadfile = file_put_contents($path, $myfile);
                                $b4hproductImg_data['product_id'] = $b4hproduct_id;
                                $b4hproductImg_data['product_image'] = $image_name;
                                $b4hproductImg_data['status'] = 1;


                                if (empty($b4hcheck_productImg_exist)) {
                                    $this->db->insert('product_images', $b4hproductImg_data);
                                } else {
                                    $this->db->where('id', $b4hcheck_productImg_exist['id']);
                                    $this->db->update('product_images', $b4hproductImg_data);
                                }
                            }
                        }
                    }
                    /*                     * ***** End Product Images ****** */
                    $productVariations_list = $this->getProductVariations($product_value['id']);
                    if (!empty($productVariations_list)) {

                        foreach ($productVariations_list as $productVariations) {
                            if($productVariations['purchasable'] == true)
                            {

                                $sizeType = $this->db->select('*')
                                                ->from('size_type')
                                                ->where("size_type", 'General')
                                                ->get()->row_array();

                                if (!empty($sizeType)) {
                                    $sizeTypeid = $sizeType['id'];
                                } else {
                                    $size_type_data['size_type'] = 'General';
                                    $size_type_data['status'] = 1;
                                    $this->db->insert('size_type', $size_type_data);
                                    $sizeTypeid = $this->db->insert_id();
                                }


                                $productAtt = $productVariations['attributes'];
                                if (!empty($productAtt)) {

                                    $option1 = isset($productAtt[0]['option']) ? $productAtt[0]['option'] : "";
                                    $option2 = isset($productAtt[1]['option']) ? $productAtt[1]['option'] : "";
                                    
                                    $size = '';
                                    if(isset($option1) && $option1!=''){
                                        $size .= $option1;
                                    }
                                    if(isset($option2) && $option2!=''){
                                        $size .= " - ".$option2;
                                    }

                                    //$size = $option1." - ".$option2;
                                    $sizeCheck = $this->db->select('*')
                                                    ->from('size')
                                                    ->where("size_type", $sizeTypeid)
                                                    ->where("size", $size)
                                                    ->get()->row_array();

                                    if (empty($sizeCheck)) {
                                        $size_data['size_type'] = $sizeTypeid;
                                        $size_data['size'] = $size;
                                        $size_data['status'] = 1;

                                        $this->db->insert('size', $size_data);
                                        $sizeId = $this->db->insert_id();
                                    } else {
                                        $sizeId = $sizeCheck['id'];
                                    }

                                    $checkProductPriceExist = $this->db->select('*')
                                            ->where('size_type', $sizeTypeid)
                                            ->where('size_id', $sizeId)
                                            ->where('product_id', $b4hproduct_id)
                                            ->get('product_price_details')
                                            ->row_array();

                                    $productPriceData['product_id'] = $b4hproduct_id;
                                    $productPriceData['size_type'] = $sizeTypeid;
                                    $productPriceData['size_id'] = $sizeId;
                                    $productPriceData['quantity'] = isset($productVariations['stock_quantity']) ? $productVariations['stock_quantity'] : 0;
                                    $productPriceData['low_level'] = 0;
                                    $productPriceData['service_tax'] = 0;
                                    $productPriceData['mrp'] = isset($productVariations['regular_price']) ? $productVariations['regular_price'] : 0;
                                    $productPriceData['price'] = isset($productVariations['price']) ? $productVariations['price'] : 0;
                                    $productPriceData['status'] = 1;

                                    if (empty($checkProductPriceExist)) {
                                        $this->db->insert('product_price_details', $productPriceData);
                                    } else {
                                        $this->db->where('id', $checkProductPriceExist['id']);
                                        $this->db->update('product_price_details', $productPriceData);
                                    }
                                }
                            }
                        }
                    } else {

                        $sizeType = $this->db->select('*')
                                        ->from('size_type')
                                        ->where("size_type", 'Free')
                                        ->get()->row_array();

                        if (!empty($sizeType)) {
                            $sizeTypeid = $sizeType['id'];
                        } else {
                            $size_type_data['size_type'] = 'Free';
                            $size_type_data['status'] = 1;
                            $this->db->insert('size_type', $size_type_data);
                            $sizeTypeid = $this->db->insert_id();
                        }

                        $sizeCheck = $this->db->select('*')
                                        ->from('size')
                                        ->where("size_type", $sizeTypeid)
                                        ->where("size", 'Free')
                                        ->get()->row_array();

                        if (empty($sizeCheck)) {
                            $size_data['size_type'] = $sizeTypeid;
                            $size_data['size'] = 'Free';
                            $size_data['status'] = 1;

                            $this->db->insert('size', $size_data);
                            $sizeId = $this->db->insert_id();
                        } else {
                            $sizeId = $sizeCheck['id'];
                        }

                        $checkProductPriceExist = $this->db->select('*')
                                ->where('size_type', $sizeTypeid)
                                ->where('size_id', $sizeId)
                                ->where('product_id', $b4hproduct_id)
                                ->get('product_price_details')
                                ->row_array();

                        $productPriceData['product_id'] = $b4hproduct_id;
                        $productPriceData['size_type'] = $sizeTypeid;
                        $productPriceData['size_id'] = $sizeId;
                        $productPriceData['quantity'] = isset($product_value['stock_quantity']) ? $product_value['stock_quantity'] : 0;
                        $productPriceData['low_level'] = 0;
                        $productPriceData['service_tax'] = 0;
                        $productPriceData['mrp'] = isset($product_value['regular_price']) ? $product_value['regular_price'] : 0;
                        $productPriceData['price'] = isset($product_value['price']) ? $product_value['price'] : 0;
                        $productPriceData['status'] = 1;

                        if (empty($checkProductPriceExist)) {
                            $this->db->insert('product_price_details', $productPriceData);
                        } else {
                            $this->db->where('id', $checkProductPriceExist['id']);
                            $this->db->update('product_price_details', $productPriceData);
                        }
                    }
                }
            }
        }
        
        echo "Records inserted successfully.";exit;
        /*         * ***** End Product ****** */
    }

    public function categoryList() {

        $x = 1;
        do {
            $url = "https://www.buy4health.com/wp/wp-json/wc/v3/products/categories?page=$x";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:' . AUTHORIZATION_TOKEN));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
            $category = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (!empty($category)) {

                foreach ($category as $key => $value) {

                    $category_list[] = $value;
                }
            }
            $x++;
        } while (count($category) > 0);

        return $category_list;
    }

    public function getProducts() {

        $x = 1;
        do {
            $url = "https://www.buy4health.com/wp/wp-json/wc/v3/products?page=$x";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:' . AUTHORIZATION_TOKEN));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
            $products = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (!empty($products)) {
                $product_list[] = $products;
            }
            $x++;
//        } while (count($products) > 10);
        } while (count($products) > 0);

        return $product_list;
    }

    public function getProductVariations($product_id) {

        $productVariations = array();
        $x = 1;
        do {

//            $url = "https://www.buy4health.com/wp/wp-json/wc/v3/products/1764/variations?page=$x";
            $url = "https://www.buy4health.com/wp/wp-json/wc/v3/products/" . $product_id . "/variations?page=$x";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:' . AUTHORIZATION_TOKEN));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
            $variations = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (!empty($variations)) {

                foreach ($variations as $key => $value) {
                    $productVariations[] = $value;
                }
            }
            $x++;

//        } while (count($products) > 10);
        } while (count($variations) > 0);

        return $productVariations;
    }

}

<?php
class ModelExtensionModuleColors extends Model {
    public function updateColors($data) {
        $colors = $this->sanitizeColors($data);

        $json_colors = $this->db->escape(json_encode($colors));
        $store_id = (int)$this->config->get('config_store_id');
        $existingSetting =  $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'module_colors_setup'")->rows;

        if (count($existingSetting) > 0) {
            $this->db->query("
                UPDATE " . DB_PREFIX . "setting 
                    SET `value` = '" . $json_colors . "'
                WHERE `key` = 'module_colors_setup' AND `store_id` = $store_id");
        }
        else {
            $this->db->query("
                INSERT INTO " . DB_PREFIX . "setting 
                    SET `value` = '" . $json_colors . "',
                    `key` = 'module_colors_setup',
                    `code` = 'module_colors',
                    `serialized` = 0,
                    `store_id` = $store_id");
        }

        $stylesheet = $this->generateStylesheet($colors);
        $this->saveStylesheet($stylesheet);
    }

    public function getColors() {
        $store_id = (int)$this->config->get('config_store_id');
        $existingSetting =  $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'module_colors_setup'")->rows;
        
        
        $default_colors = [
            'color_primary' => '#229ac8',
            'color_primary_variant' => '#1f90bb',
            'color_secondary' => '#e7e7e7',
            'color_secondary_variant' => '#eeeeee',
            'color_text_primary' => '#ffffff',
            'color_text_secondary' => '#777777',
            'color_paragraphs' => '#666666',
            'color_edges' => '#dddddd',
            'color_surface_primary' => '#ffffff',
            'color_surface_secondary' => '#f5f5f5',
            'color_alternative' => '#303030',
            'color_titles' => '#444'
        ];

        $colors = [];
        if (count($existingSetting) > 0)
            $colors = json_decode($existingSetting[0]['value'], true);

        foreach($default_colors as $key=>$value) {
            if (!isset($colors[$key]) || empty($colors[$key]))
                $colors[$key] = $default_colors[$key];
        }

        return $colors;
    }

    public function generateStylesheet($colors) {
        $stylesheet = "";
        $color_primary = $colors['color_primary'];
        $color_primary_variant = $colors['color_primary_variant'];
        $color_secondary = $colors['color_secondary'];
        $color_secondary_variant = $colors['color_secondary_variant'];
        $color_text_primary = $colors['color_text_primary'];
        $color_text_secondary = $colors['color_text_secondary'];
        $color_paragraphs = $colors['color_paragraphs'];
        $color_edges = $colors['color_edges'];
        $color_surface_primary = $colors['color_surface_primary'];
        $color_surface_secondary = $colors['color_surface_secondary'];
        $color_alternative = $colors['color_alternative'];
        $color_titles = $colors['color_titles'];
        
        $defaultLightenColorBrightness = 1.1;
        $defaultDarkenColorBrightness = 0.8;

        $color_primary_lighten = $this->changeColorBrightness($color_primary, $defaultLightenColorBrightness);
        $color_primary_variant_lighten = $this->changeColorBrightness($color_primary_variant, $defaultLightenColorBrightness);
        $color_primary_variant_lighten_lighten = $this->changeColorBrightness($color_primary_variant_lighten, $defaultLightenColorBrightness);
        $color_secondary_lighten = $this->changeColorBrightness($color_secondary, $defaultLightenColorBrightness);
        $color_secondary_variant_lighten = $this->changeColorBrightness($color_secondary_variant, $defaultLightenColorBrightness);
        $color_text_primary_lighten = $this->changeColorBrightness($color_text_primary, $defaultLightenColorBrightness);
        $color_text_secondary_lighten = $this->changeColorBrightness($color_text_secondary, $defaultLightenColorBrightness);
        $color_edges_lighten = $this->changeColorBrightness($color_edges, $defaultLightenColorBrightness);
        $color_surface_primary_lighten = $this->changeColorBrightness($color_surface_primary, $defaultLightenColorBrightness);
        $color_surface_secondary_lighten = $this->changeColorBrightness($color_surface_secondary, $defaultLightenColorBrightness);
        $color_paragraphs_lighten = $this->changeColorBrightness($color_paragraphs, $defaultLightenColorBrightness);
        $color_alternative_lighten = $this->changeColorBrightness($color_alternative, $defaultLightenColorBrightness);
        $color_titles_lighten = $this->changeColorBrightness($color_titles, $defaultLightenColorBrightness);

        $color_primary_darken = $this->changeColorBrightness($color_primary, $defaultDarkenColorBrightness);
        $color_primary_variant_darken = $this->changeColorBrightness($color_primary_variant, $defaultDarkenColorBrightness);
        $color_primary_variant_darken_darken = $this->changeColorBrightness($color_primary_variant_darken, $defaultDarkenColorBrightness);
        $color_secondary_darken = $this->changeColorBrightness($color_secondary, $defaultDarkenColorBrightness);
        $color_secondary_variant_darken = $this->changeColorBrightness($color_secondary_variant, $defaultDarkenColorBrightness);
        $color_text_primary_darken = $this->changeColorBrightness($color_text_primary, $defaultDarkenColorBrightness);
        $color_text_secondary_darken = $this->changeColorBrightness($color_text_secondary, $defaultDarkenColorBrightness);
        $color_edges_darken = $this->changeColorBrightness($color_edges, $defaultDarkenColorBrightness);
        $color_surface_primary_darken = $this->changeColorBrightness($color_surface_primary, $defaultDarkenColorBrightness);
        $color_surface_secondary_darken = $this->changeColorBrightness($color_surface_secondary, $defaultDarkenColorBrightness);
        $color_paragraphs_darken = $this->changeColorBrightness($color_paragraphs, $defaultDarkenColorBrightness);
        $color_alternative_darken = $this->changeColorBrightness($color_alternative, $defaultDarkenColorBrightness);
        $color_titles_darken = $this->changeColorBrightness($color_titles, $defaultDarkenColorBrightness);

        $stylesheet .= "
            body {
                background-color: $color_surface_primary;
                background-image: linear-gradient(to bottom, $color_surface_primary 70%, $color_surface_secondary);
                color: $color_paragraphs;
            }
            #top #form-language .language-select:hover {
                background-color: $color_primary;
                background-image: linear-gradient(to bottom, $color_primary_lighten, $color_primary_variant_lighten);
            }
            #cart > .btn {
                color: $color_text_primary;
            }
            #cart.open > .btn {
                color: $color_titles;
            }
            #cart.open > .btn:hover {
                color: $color_titles_darken;
            }
            #cart .dropdown-menu {
                background-color: $color_surface_secondary;
            }
            #menu {
                background-color: $color_primary;
                background-image: linear-gradient(to bottom, $color_primary, $color_primary_variant);
                border-color: $color_edges;
            }
            #menu .btn-navbar {
                background-color: $color_primary;
                color: $color_text_primary;
                background-image: linear-gradient(to bottom, $color_primary_lighten, $color_primary_darken);
                border-color: $color_edges_lighten $color_edges $color_edges_darken;
                box-shadow: 0 0 6px $color_edges_darken;
            }   
            #menu .btn-navbar:hover, #menu .btn-navbar:focus, #menu .btn-navbar:active, #menu .btn-navbar.disabled, #menu .btn-navbar[disabled] {
                background-color: $color_primary;
            }
            #menu .btn-navbar:hover, #menu .btn-navbar:focus {
                background-color: $color_primary_lighten;
                background-image: linear-gradient(to bottom, $color_primary_lighten, $color_primary_lighten);
                color: $color_text_primary_darken;
            }   
            #menu .nav > li > a {
                color: $color_text_primary;
            }
            #menu .dropdown-inner li a:hover {
                color: $color_text_primary;
            }
            #menu #category {
                color: $color_text_primary;
            }
            #menu .dropdown-inner a {
                color: $color_titles;
            }
            .dropdown-menu {
                border-color: $color_edges;
                background: $color_surface_secondary;
            }
            .dropdown-menu li > a:hover {
                background-color: $color_primary;
                background-image: linear-gradient(to bottom, $color_primary, $color_primary_variant);
            }
            #menu .see-all:hover, #menu .see-all:focus {
                background-color: $color_primary;
                background-image: linear-gradient(to bottom, $color_primary, $color_primary_variant);
                color: $color_text_primary;
            }
            .form-control {
                border-color: $color_edges;
            }
            .btn { 
                border-color: $color_edges;
            }
            .btn-primary {
                background-color: $color_primary;
                background-image: linear-gradient(to bottom, $color_primary, $color_primary_variant);
                border-color: $color_edges;
                color: $color_text_primary;
            }
            .btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled] {
                background-color: $color_primary_lighten;
                background-image: linear-gradient(to bottom, $color_primary_lighten, $color_primary_variant_lighten);
                border-color: $color_edges_darken;
                background-position: 0 -0;
            }
            .btn-link {
                color: $color_primary;
            }
            .list-group a {
                border-color: $color_edges !important;
                color: $color_paragraphs_lighten !important;
                background-color: $color_surface_secondary;
            }
            .list-group a.active, .list-group a.active:hover, .list-group a:hover {
                background-color: $color_surface_secondary_lighten;
                color: $color_paragraphs_darken;
            }
            li.active>a {
                color: $color_secondary_variant;
            }
            .btn-default {
                color: $color_text_secondary;
                background-color: $color_secondary;
                background-image: linear-gradient(to bottom, $color_secondary, $color_secondary_variant);
                border-color: $color_edges;
            }
            .btn-default:hover {
                color: $color_text_secondary_darken;
                background-image: linear-gradient(to bottom, $color_secondary_lighten,  $color_secondary_variant_lighten);
                border-color: $color_edges_darken;
            }
            .btn-default.active, .btn-default:active, .open>.dropdown-toggle.btn-default {
                color: $color_text_secondary_darken;
                background-color: $color_secondary_darken !important;
                background-image: linear-gradient(to bottom, $color_secondary_darken, $color_secondary_variant_darken) !important;
            }
            .btn-link:focus, .btn-link:hover {
                color: $color_secondary_darken;
                border-color: $color_edges_lighten;
            }
            footer {
                background-color: $color_alternative !important;
                background-image: linear-gradient(to bottom, $color_alternative, $color_alternative_darken) !important;
                color: $color_text_primary_darken;
            }     
            footer h5 {
                color: $color_text_primary;
            }
            footer a {
                color: $color_text_primary_darken;
            }
            footer a:hover, footer a:active, footer a:focus {
                color: $color_text_primary_lighten;
            }
            footer hr {
                border-bottom-color: $color_edges;
            }
            hr {
                border-color: $color_edges;
            }
            .btn-inverse {
                background-color: $color_alternative;
                background-image: linear-gradient(to bottom, $color_alternative, $color_alternative_darken);
                border-color: $color_edges_darken;
                color: $color_text_secondary;
                box-shadow: 0 1px 4px $color_edges;
            }
            .btn-inverse:hover {
                background-color: $color_alternative;
                background-image: linear-gradient(to bottom, $color_alternative_darken, $color_alternative_lighten);
                border-color: $color_edges_darken;
            }
            .product-thumb {
                border-radius: 4px;
                background-color: $color_surface_secondary;
                background-image: linear-gradient(to bottom, $color_surface_secondary, $color_surface_secondary_lighten);
                box-shadow: 0 1px 6px $color_edges;
                border: none;
            }
            .product-thumb .image {
                border-bottom: 1px solid $color_edges_lighten;
                background-color: white;
            }
            .product-thumb .price {
                color: $color_text_secondary_darken;
            }
            .product-thumb .button-group button {
                color: $color_text_secondary;
                background-color: $color_secondary;
                background-image: linear-gradient(to bottom, $color_secondary, $color_secondary_variant);
            }
            .product-thumb .button-group button:hover {
                background-color: $color_secondary_lighten;
                background-image: linear-gradient(to bottom, $color_secondary_lighten, $color_secondary_variant_lighten);
                color: $color_text_secondary_darken;
            }
            .product-thumb .button-group button + button {
                border-left: 1px solid $color_edges;
            }
            .panel-default, .panel-default>.panel-heading {
                background-color: $color_surface_secondary;
                border-color: $color_edges;
            }
            .panel-group .panel-heading+.panel-collapse>.list-group, .panel-group .panel-heading+.panel-collapse>.panel-body {
                border-top-color: $color_edges;
                background-color: $color_surface_secondary;
            }
            .panel-title {
                color: $color_paragraphs_darken;
            }
            .table-striped>tbody>tr:nth-of-type(odd) {
                background-color: $color_surface_secondary;
            }
            .breadcrumb {
                background-color: $color_surface_secondary;
                border-color: $color_edges;
            }
            .breadcrumb > li:after {
                border-right-color: $color_edges;
                border-bottom-color: $color_edges;
            }
            .well {
                background-color: $color_surface_secondary;
                border-color: $color_edges;
            }
            .thumbnail {
                border-color: $color_edges !important;
            }
            .thumbnail:hover {
                border-color: $color_edges_darken !important;
            }
            .swiper-viewport {
                box-shadow: 0 1px 4px $color_edges !important;
            }    
            .swiper-pagination-bullet {
                background-color: $color_primary !important;
            }
            .swiper-pagination-bullet-active {
                background-color: $color_secondary !important;
            }
            .swiper-button-prev:before {
                color: $color_primary_variant !important;
            }
            .swiper-button-next:before {
                color: $color_primary_variant !important;
            }
            h1, h2, h3, h4, h5, h6 {
                color: $color_titles;
            }      
            h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
                color: $color_titles;
            }
            a {
                color: $color_primary_lighten;
            }  
            a:focus, a:hover {
                color: $color_primary_darken;
            }
            #top {
                background-color: $color_secondary_variant;
            }   
            #top .btn-link, #top-links li, #top-links a {
                color: $color_text_secondary;
            }     
            #top .btn-link:hover, #top-links a:hover {
                color: $color_text_secondary_darken;
            }
            #top-links .dropdown-menu a:hover {
                color: $color_text_primary;
            }
            .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
                border-color: $color_edges;
            }
            .table-responsive {
                border-color: $color_edges;
            }
            .product-thumb .price-tax {
                color: $color_paragraphs_lighten;
            }
            .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
                border-color: $color_edges;
                border-bottom-color: transparent;
                color: $color_paragraphs_lighten;
            }
            .nav>li>a:focus, .nav>li>a:hover {
                background-color: $color_surface_secondary;
            }
            .nav-tabs {
                border-bottom-color: $color_edges;
            }
            .nav-tabs>li>a:hover {
                border-color: $color_edges;
            }
            .input-group-addon {
                color: $color_paragraphs;
                border-color: $color_edges;
                background-color: $color_surface_secondary;
            }
            .list-group-item {
                background-color: transparent;
            }
            a.list-group-item:focus, button.list-group-item:focus {
                background-color: $color_surface_secondary;
            }
            .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
                background-color: $color_surface_secondary;
            }
            .btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open>.dropdown-toggle.btn-default.focus, .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover {
                color: $color_text_secondary_darken;
            }
            .product-thumb .button-group {
                border-color: $color_edges_lighten;
            }
            .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
                background-color: $color_surface_primary;
            }
        ";

        return $stylesheet;
    }   

    public function saveStylesheet($stylesheet) {
        file_put_contents(DIR_CATALOG.'view/theme/default/stylesheet/stylesheet_colors.css', $stylesheet);
        $this->clearTemplateCache();
    }

    public function clearTemplateCache() {
        $this->deleteDirectory(DIR_CACHE);
        mkdir(DIR_CACHE);
        file_put_contents(DIR_CACHE . 'index.html', '');
    }

    private function deleteDirectory($dirname) {
        $dirname = preg_replace("/(.*)\/$/", '$1', $dirname);
        if ($dir = opendir($dirname)) {
            while (false !== ($file = readdir($dir))) {
                if ($file == '.' || $file == '..')
                    continue;
                $file = $dirname . '/' . $file;
                if (is_file($file))
                    unlink($file);
                else if (is_dir($file))
                    $this->deleteDirectory($file);
            }
            closedir($dir);
            rmdir($dirname);
        }
    }

    private function changeColorBrightness($color, $percent) {
        preg_match_all("/[0-9a-f]{2}/i", $color, $result);
        $parts = $result[0];

        $red = hexdec($parts[0]) * $percent;
        $green = hexdec($parts[1]) * $percent;
        $blue = hexdec($parts[2]) * $percent;

        if ($red > 255) $red = 255;
        if ($green > 255) $green = 255;
        if ($blue > 255) $blue = 255;
        if ($red < 0) $red = 0;
        if ($green < 0) $green = 0;
        if ($blue < 0) $blue = 0;

        $red = sprintf("%02s", dechex($red));
        $green = sprintf("%02s", dechex($green));
        $blue = sprintf("%02s", dechex($blue));

        return "#" . $red . $green . $blue;
    }

    public function sanitizeColors($data) {
        $colors = [
            'color_primary' => trim($this->db->escape($data['color_primary'])),
            'color_primary_variant' => trim($this->db->escape($data['color_primary_variant'])),
            'color_secondary' => trim($this->db->escape($data['color_secondary'])),
            'color_secondary_variant' => trim($this->db->escape($data['color_secondary_variant'])),
            'color_text_primary' => trim($this->db->escape($data['color_text_primary'])),
            'color_text_secondary' => trim($this->db->escape($data['color_text_secondary'])),
            'color_paragraphs' => trim($this->db->escape($data['color_paragraphs'])),
            'color_edges' => trim($this->db->escape($data['color_edges'])),
            'color_surface_primary' => trim($this->db->escape($data['color_surface_primary'])),
            'color_surface_secondary' => trim($this->db->escape($data['color_surface_secondary'])),
            'color_alternative' => trim($this->db->escape($data['color_alternative'])),
            'color_titles' => trim($this->db->escape($data['color_titles']))
        ];
        return $colors;
    }
}
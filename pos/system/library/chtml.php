<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// html_form.class.php
// version date: March 2010

class CHTML {

    public function startForm($action = '#', $method = 'post', $id = NULL, $attr_ar = array()) {
        $str = "<form action=\"$action\" method=\"$method\"";
        if (isset($id)) {
            $str .= " id=\"$id\"";
        }
        $str .= $attr_ar ? $this->addAttributes($attr_ar) . '>' : '>';
        return $str;
    }

    private function addAttributes($attr_ar) {
        $str = '';
// check minimized attributes
        $min_atts = array('checked', 'disabled', 'readonly', 'multiple');
        foreach ($attr_ar as $key => $val) {
            if (in_array($key, $min_atts)) {
                if (!empty($val)) {
                    $str .= " $key=\"$key\"";
                }
            } else {
                $str .= " $key=\"$val\"";
            }
        }
        return $str;
    }

    public function addInput($type, $name, $value, $attr_ar = array()) {
        $str = "<input type=\"$type\" name=\"$name\" value=\"$value\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ' />';
        return $str;
    }

    public function addTextarea($name, $rows = 4, $cols = 30, $value = '', $attr_ar = array()) {
        $str = "<textarea name=\"$name\" rows=\"$rows\" cols=\"$cols\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">$value</textarea>";
        return $str;
    }

    public function addLabel($text, $attr_ar = array()) {
        $str = "<label ";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">$text</label>";
        return $str;
    }

// for attribute refers to id of associated form element
    public function addLabelFor($forID, $text, $attr_ar = array()) {
        $str = "<label for=\"$forID\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">$text</label>";
        return $str;
    }

// from parallel arrays for option values and text
    public function addSelectListArrays($name, $val_list, $txt_list, $selected_value = NULL, $header = NULL, $attr_ar = array()) {
        $option_list = array_combine($val_list, $txt_list);
        $str = $this->addSelectList($name, $option_list, true, $selected_value, $header, $attr_ar);
        return $str;
    }

// option values and text come from one array (can be assoc)
// $bVal false if text serves as value (no value attr)
    public function addSelectList($name, $option_list, $bVal = true, $selected_value = NULL, $header = NULL, $attr_ar = array()) {
        $str = "<select name=\"$name\"";
        if ($attr_ar) {
            $str .= $this->addAttributes($attr_ar);
        }
        $str .= ">\n";
        if (isset($header)) {
            $str .= "  <option value=\"\">$header</option>\n";
        }
        foreach ($option_list as $val => $text) {
            $str .= $bVal ? "  <option value=\"$val\"" : "  <option";
            if (isset($selected_value) && ( $selected_value === $val || $selected_value === $text)) {
                $str .= ' selected="selected"';
            }
            $str .= ">$text</option>\n";
        }
        $str .= "</select>";
        return $str;
    }

    public function endForm() {
        return "</form>";
    }

}

?>

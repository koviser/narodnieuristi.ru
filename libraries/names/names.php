<?php


/**
 * ��������� ������� ��� � �������
 *
 * var rn = new RussianName('����������� ������ �����������');
 * rn.fullName(rn.gcaseRod); // ������������ ������� ������������
 *
 * ������ �������� �� ������� ��. ���� � ����.
 *
 * ����������, ���������� ���� ��������� ��� �� �����. �������.
 *
 * @version  0.1.3
 * @author   Johnny Woo <agalkin@agalkin.ru>
 */

 
class lastName {
    var $exceptions = array(
        "	����,����,����,����,�����,�������,������ . . . . .",
        '	����,������,������,����,������,�������,����������,�������,����,���� . . . . .',
        '	���,���,���,��� -� -� -� -�� -�'
    );
    var $suffixes = array(
        'f	�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,� . . . . .',
        'f	���,���  -�� -�� -�� -�� -��',
        'f	��       --�� --�� --�� --�� --��',
        '	����     --�� --�� --�� --�� --��',
        'f	��       -�� -�� -� -�� -��',

        '	���� -� -� -� -�� -�',
        '	��   -� -� -� -�� -�',
        '	��   -� -� -� -�� -�',

        '	���  � � � �� �',

        '	��                      . . . . .',
        '	��,��,��,��,��,��,��,�� . . . . .',
        '	��,��                   . . . . .',
        '	�,�,�,�,�,�,�           . . . . .',

        '	���,���            -�� -�� -� -�� -��',
        '	��,��,��,��,��,��  -� -� -� -�� -�',
        '	��  -� -� -� -�� -�',
        '	�   -� -� -� -�� -�',

        '	�   -� -� -� -�� -�',

        '	��  -� -� -� -�� -�',
        '	�   -� -� -� -�� -�',
        '	��  -� -� -� -�� -�',

        '	��,��,��   � � � �� �',

        '	����,����  --�� --�� --�� --��� --��',
        '	����,����  --�� --�� --�� --��� --��',

        '	�,�,�,�   � � � �� �',

        '	��  -� -� -� -�� -�',
        '	��  -�� -�� -�� --�� -�',
        '	��,��   � � � �� �',

        '	���,���,���,���  --��� --��� --��� -� --��',
        '	���,��   --��� --��� --��� -� --��',
        '	��       -� -� -� -�� -�',

        '	��  --�� --�� --�� --��� --��',
        '	��  --�� --�� --�� --��� --��',

        '	�,�   � � � �� �',
        '	�,�,�,�,�,�,�,�,�,�,�,�,�,�   � � � �� �'
    );
}

class firstName {
    var $exceptions = array (
        '	���    --��� --��� --��� --���� --���',
        '	�����  --��  --��  --��  --���  --��',
        'm	����   . . . . .',
        'f	������,������,������,��������,�������   . . . . .'
    );
    var $suffixes = array(
        '	�,�,�,�,�,�,�,�   . . . . .',
        'f	�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�   . . . . .',

        'f	�   -� -� . � -�',
        'm	�   -� -� -� -�� -�',

        '	��,��,��,��,��,��  -� -� -� -�� -�',
        '	�   -� -� -� -�� -�',
        '	��  -� -� -� -�� -�',
        '	�   -� -� -� -�� -�',
        '	��  -� -� -� -�� -�',
        '	��  -� -� -� -�� -�',
        '	�   -� -� -� -�� -�',
        '	�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�	 � � � �� �'
    );
}

class middleName {
	var $exceptions = array();
    var $suffixes = array (
        '	��   �  �  �  ��  �',
        '	��  -� -� -� -�� -�'
    );
}
        
class Rules {
    var $lastName, $firstName, $middleName;
    function Rules(){
        $this->lastName = new lastName();
        $this->firstName = new firstName();
        $this->middleName = new middleName();
    }
}

class RussianNameProcessor {
    var $sexM = 'm';
    var $sexF = 'f';
    var $gcaseIm =  'nominative';      var $gcaseNom = 'nominative';      // ������������
    var $gcaseRod = 'genitive';        var $gcaseGen = 'genitive';        // �����������
    var $gcaseDat = 'dative';                                       // ���������
    var $gcaseVin = 'accusative';      var $gcaseAcc = 'accusative';      // �����������
    var $gcaseTvor = 'instrumentative';var $gcaseIns = 'instrumentative'; // ������������
    var $gcasePred = 'prepositional';  var $gcasePos = 'prepositional';   // ����������
    
    var $fullNameSurnameLast = false;
    var $ln = '', $fn = '', $mn = '', $sex = '';

    var $rules;
    var $initialized = false;

    function init(){
        if ( $this -> initialized ) { 
            return;
        }
        $this->rules = new rules();
        $this->prepareRules();
        $this -> initialized = true;
    }
    
    function RussianNameProcessor ($lastName, $firstName = NULL, $middleName = NULL, $sex = NULL) {
        $this->init();
        if (!isset($firstName)) {
            preg_match("/^\s*(\S+)(\s+(\S+)(\s+(\S+))?)?\s*$/", $lastName, $m);
            if(!$m) exit("Cannot parse supplied name");
            if($m[5] && preg_match("/(��|��)$/",$m[3]) && !preg_match("/(��|��)$/",$m[5])) {
                // ���� �������� �������
                $lastName = $m[5];
                $firstName = $m[1];
                $middleName = $m[3];
                $this -> fullNameSurnameLast = true;
            } else {
                // ������� ���� ��������
                $lastName = $m[1];
                $firstName = $m[3];
                $middleName = $m[5];
            }
        }
        $this -> ln = $lastName;
        if (isset($firstName)) $this -> fn = $firstName;
        else $this -> fn = '';
        if (isset($middleName)) $this -> mn = $middleName;
        else $this -> mn = '';
        if (isset($sex)) $this -> sex = $sex;
		else $this -> sex = $this -> getSex();
        
        return;
    }

    function prepareRules () {
        foreach ( array("lastName", "firstName", "middleName") as $type ) {
            foreach(array("suffixes" ,"exceptions") as $key) {
                $n = count($this -> rules->$type->$key);
                for ($i = 0; $i < $n; $i++) {
                    $this->rules->$type->{$key}[$i] = $this->rule($this->rules->$type->{$key}[$i]);
                }
            }
        }
    }

    function rule ($rule) {
        preg_match("/^\s*([fm]?)\s*(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s*$/", $rule, $m);
            if ( $m ) return array (
            "sex" => $m[1],
            "test" => split(',', $m[2]),
            "mods" => array ($m[3], $m[4], $m[5], $m[6], $m[7])
        );
        return false;
    }

    // �������� ����� �� ���������� ������ ������ � ����������
    function word ($word, $sex, $wordType, $gcase) {
        // �������� ����� ��������� � ������������ ������
        if( $gcase == $this->gcaseNom) return $word;

        // ��������� �����
        if( preg_match("/[-]/", $word)) {
                $list = $word->split('-');
                $n = count($list);
                for($i = 0; $i < $n; $i++) {
                        $list[$i] = $this->word($list[$i], $sex, $wordType, $gcase);
                }
                return join('-', $list);
        }

        // ������ �. �.
        if ( preg_match("/^[�-ߨ]\.?$/i", $word)) return $word;
        $this->init();
        $rules = $this->rules->$wordType;

        if ( $rules->exceptions) {
                $pick = $this->pick($word, $sex, $gcase, $rules->exceptions, true);
                if ( $pick ) return $pick;
        }
        $pick = $this->pick($word, $sex, $gcase, $rules->suffixes, false);
        if ($pick) return $pick;
        else return $word;
    }

    // �������� �� ������ ������ ������ ���������� � ��������� 
    function pick ($word, $sex, $gcase, $rules, $matchWholeWord) {
        $wordLower = strtolower($word);
        $n = count($rules);
        for($i = 0; $i < $n; $i++) {
            if ( $this->ruleMatch($wordLower, $sex, $rules[$i], $matchWholeWord)) {
                return $this->applyMod($word, $gcase, $rules[$i]);
            }
        }
        return false;
    }


    // ���������, �������� �� ������� � �����
    function ruleMatch ($word, $sex, $rule, $matchWholeWord) {
        if ($rule["sex"] == $this->sexM && $sex == $this->sexF) return false; // male by default
        if ($rule["sex"] == $this->sexF && $sex != $this->sexF) return false;
        $n = count($rule["test"]);
        for($i = 0; $i < $n; $i++) {
            $test = $matchWholeWord ? $word : substr($word, max(strlen($word) - strlen($rule["test"][$i]), 0));
            if($test == $rule["test"][$i]) return true;
        }
        return false;
    }

    // �������� ����� (������ ���������)
    function applyMod($word, $gcase, $rule) {
        switch($gcase) {
            case $this -> gcaseNom: $mod = '.'; break;
            case $this -> gcaseGen: $mod = $rule["mods"][0]; break;
            case $this -> gcaseDat: $mod = $rule["mods"][1]; break;
            case $this -> gcaseAcc: $mod = $rule["mods"][2]; break;
            case $this -> gcaseIns: $mod = $rule["mods"][3]; break;
            case $this -> gcasePos: $mod = $rule["mods"][4]; break;
            default: exit("Unknown grammatic case: "+gcase);
        }
        $n = strlen($mod);
        for($i = 0; $i < $n; $i++) {
            $c = substr($mod, $i, 1);
            switch($c) {
                case '.': break;
                case '-': $word = substr($word, 0, strlen($word) - 1); break;
                default: $word .= $c;
            }
        }
        return $word;
    }
    
    function getSex() {
        if( strlen($this->mn) > 2) {
            switch(substr($this->mn, -2)) {
                case '��': return $this->sexM;
                case '��': return $this->sexF;
            }
        }
        return '';
    }
	
    function fullName($gcase) {
    	$tmpstr = ($this->fullNameSurnameLast ? '' : $this->lastName($gcase) . ' ')
            . $this -> firstName($gcase) . ' ' . $this -> middleName($gcase)
            . ($this -> fullNameSurnameLast ? ' ' . $this -> lastName($gcase) : ''); 
        return preg_replace("/^ +| +$/", '', $tmpstr);
    }
    
    function lastName($gcase) {
        return $this->word($this -> ln, $this -> sex, 'lastName', $gcase);  
    }
    
    function firstName($gcase) {
        return $this->word($this -> fn, $this -> sex, 'firstName', $gcase);
    }
    
    function middleName($gcase) {
        return $this->word($this -> mn, $this -> sex, 'middleName', $gcase);
    }
}






?>

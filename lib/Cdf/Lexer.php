<?php
/*
 *  OPEN POWER LIBS <http://www.invenzzia.org>
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 * $Id$
 */

/**
 * The lexer class for the CDF parser. Note: this file
 * is automatically generated by PHP Parser Generator lexer
 * by Gregory Beaver. Do not modify it manually. Instead,
 * use the file /tools/lexer/cdf_lexer.plex and parse
 * it with /tools/lexer/generateCdf.php.
 */
class Opt_Cdf_Lexer
{
	/**
	 * The data field for the lexical analyzer.
	 */
	private $_data;
	/**
	 * The token counter for the lexical analyzer.
	 */
	private $_counter;
	/**
	 * The line counter for the lexical analyzer.
	 */
	private $_line;

	/**
	 * The recognized token number for parser.
	 * @var integer
	 */
	public $token;

	/**
	 * The recognized token value for parser.
	 * @var string
	 */
	public $value;

	/**
	 * Constructs the lexer object for parsing the specified
	 * expression.
	 *
	 * @param string $expression The expression to parse.
	 */
	public function __construct($filename)
	{
		$this->_data = file_get_contents($filename);
		$this->_line = 1;
		$this->_counter = 0;
	} // end __construct();


    private $_yy_state = 1;
    private $_yy_stack = array();

    function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    function yypushstate($state)
    {
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
    }

    function yypopstate()
    {
        $this->_yy_state = array_pop($this->_yy_stack);
    }

    function yybegin($state)
    {
        $this->_yy_state = $state;
    }




    function yylex1()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
              12 => 0,
              13 => 0,
              14 => 0,
              15 => 0,
              16 => 0,
            );
        if ($this->_counter >= strlen($this->_data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\/\\*)|^(\/\/)|^(\\s+)|^(\n|\r\n)|^([a-zA-Z_][a-zA-Z0-9]*)|^(\\{)|^(\\})|^(\\.)|^(-)|^(\/)|^(:)|^(;)|^(,)|^(#)|^(.+)|^(.+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->_data, $this->_counter), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->_data,
                        $this->_counter, 5) . '... state INITIAL');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->_counter += strlen($this->value);
                    $this->_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->_counter += strlen($this->value);
                    $this->_line += substr_count($this->value, "\n");
                    if ($this->_counter >= strlen($this->_data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                }            } else {
                throw new Exception('Unexpected input at line' . $this->_line .
                    ': ' . $this->_data[$this->_counter]);
            }
            break;
        } while (true);

    } // end function


    const INITIAL = 1;
    function yy_r1_1($yy_subpatterns)
    {

	$this->yypushstate(self::MULTILINE_COMMENT);
	$this->token = 'w';
	echo "going in multiline\n";
    }
    function yy_r1_2($yy_subpatterns)
    {

	$this->yypushstate(self::SINGLELINE_COMMENT);
	$this->token = 'w';
	echo "going in singleline\n";
    }
    function yy_r1_3($yy_subpatterns)
    {

	$this->token = 'w';
    }
    function yy_r1_4($yy_subpatterns)
    {

	$this->line++;
    }
    function yy_r1_5($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_ID;
    }
    function yy_r1_6($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_LCURBRACKET;
    }
    function yy_r1_7($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_RCURBRACKET;
    }
    function yy_r1_8($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_DOT;
    }
    function yy_r1_9($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_PAUSE;
    }
    function yy_r1_10($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_DOT;
    }
    function yy_r1_11($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_COLON;
    }
    function yy_r1_12($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_SEMICOLON;
    }
    function yy_r1_13($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_COMMA;
    }
    function yy_r1_14($yy_subpatterns)
    {

	$this->token = Opt_Cdf_Parser::T_HASH;
    }
    function yy_r1_15($yy_subpatterns)
    {

	throw new Exception('AAA!!!');
    }
    function yy_r1_16($yy_subpatterns)
    {

	throw new Exception('BBB!!!');
    }



    function yylex2()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
            );
        if ($this->_counter >= strlen($this->_data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\n|\r\n)|^(.+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->_data, $this->_counter), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->_data,
                        $this->_counter, 5) . '... state SINGLELINE_COMMENT');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->_counter += strlen($this->value);
                    $this->_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->_counter += strlen($this->value);
                    $this->_line += substr_count($this->value, "\n");
                    if ($this->_counter >= strlen($this->_data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                }            } else {
                throw new Exception('Unexpected input at line' . $this->_line .
                    ': ' . $this->_data[$this->_counter]);
            }
            break;
        } while (true);

    } // end function


    const SINGLELINE_COMMENT = 2;
    function yy_r2_1($yy_subpatterns)
    {

	$this->line++;
	$this->yypopstate();
	echo "going out singleline\n";
	$this->token = 'w';
    }
    function yy_r2_2($yy_subpatterns)
    {

	$this->token = 'w';
    }



    function yylex3()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
            );
        if ($this->_counter >= strlen($this->_data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\*\/)|^(\n|\r\n)|^(.+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->_data, $this->_counter), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->_data,
                        $this->_counter, 5) . '... state MULTILINE_COMMENT');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->_counter += strlen($this->value);
                    $this->_line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->_counter += strlen($this->value);
                    $this->_line += substr_count($this->value, "\n");
                    if ($this->_counter >= strlen($this->_data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                }            } else {
                throw new Exception('Unexpected input at line' . $this->_line .
                    ': ' . $this->_data[$this->_counter]);
            }
            break;
        } while (true);

    } // end function


    const MULTILINE_COMMENT = 3;
    function yy_r3_1($yy_subpatterns)
    {

	$this->yypopstate();
	$this->token = 'w';
	echo "going out multiline\n";
    }
    function yy_r3_2($yy_subpatterns)
    {

	$this->line++;
	$this->token = 'w';
    }
    function yy_r3_3($yy_subpatterns)
    {
	
	$this->token = 'w';
    }

} // end Opt_Cdf_Lexer;
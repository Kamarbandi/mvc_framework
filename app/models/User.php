<?php

namespace Model;

defined('ROOT_PATH') or exit('Access Denied!');

/**
 * User class
 */
class User
{
    use Model;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $loginUniqueColumn = 'email';

    protected $allowedColumns = [
        'username',
        'email',
        'password',
    ];

    /*****************************
     *    rules include:
     * required
     * alpha
     * email
     * numeric
     * unique
     * symbol
     * longer_than_8_chars
     * alpha_numeric_symbol
     * alpha_numeric
     * alpha_symbol
     *
     ****************************/
    protected $onInsertValidationRules = [
        'email' => [
            'email',
            'unique',
            'required',
        ],
        'username' => [
            'alpha',
            'required',
        ],
        'password' => [
            'not_less_than_8_chars',
            'required',
        ],
    ];

    protected $onUpdateValidationRules = [
        'email' => [
            'email',
            'unique',
            'required',
        ],
        'username' => [
            'alpha',
            'required',
        ],
        'password' => [
            'not_less_than_8_chars',
            'required',
        ],
    ];

    public function signup($data)
    {
        if ($this->validate($data)) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['date'] = date("Y-m-d H:i:s");
            $data['date_created'] = date("Y-m-d H:i:s");

            $this->insert($data);
            redirect('login');
        }
    }

    public function login($data)
    {
        $row = $this->first([$this->loginUniqueColumn => $data[$this->loginUniqueColumn]]);

        if ($row) {
            if (password_verify($data['password'], $row->password)) {
                $ses = new \Core\Session;
                $ses->auth($row);
                redirect('home');
            } else {
                $this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or password";
            }
        } else {
            $this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or password";
        }
    }

}
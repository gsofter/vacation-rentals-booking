<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute mesti diterima.',
    'active_url'           => ':attribute bukan URL yang sah.',
    'after'                => ':attribute mestilah tarikh selepas :date.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute boleh mengandungi huruf, nombor, dan sengkang.',
    'alpha_num'            => ':attribute boleh mengandungi huruf dan nombor.',
    'array'                => ':attribute mesti menjadi array.',
    'before'               => ':attribute mestilah tarikh sebelum ini :date.',
    'between'              => [
        'numeric' => ':attribute mesti mengandungi antara :min dan :max.',
        'file'    => ':attribute mesti mengandungi antara :min dan :max kilobait.',
        'string'  => ':attribute mesti mengandungi antara :min dan :max aksara.',
        'array'   => ':attribute mesti mengandungi antara :min dan :max perkara.',
    ],
    'boolean'              => ':attribute medan mestilah benar atau palsu.',
    'confirmed'            => ':attribute pengesahan tidak sepadan.',
    'date'                 => ':attribute bukan tarikh yang sah.',
    'date_format'          => ':attribute tidak sepadan dengan format :format.',
    'different'            => ':attribute dan :other must be different.',
    'digits'               => ':attribute mesti :digits digits.',
    'digits_between'       => ':attribute mesti mengandungi antara :min dan :max digits.',
    'distinct'             => 'yang :attribute medan mempunyai nilai pendua.',
    'email'                => ':attribute Mesti alamat e-mel yang sah.',
    'exists'               => 'yang dipilih :attribute tidak sah.',
    'filled'               => ':attribute medan diperlukan.',
    'image'                => ':attribute must be an image.',
    'in'                   => 'Yang dipilih :attribute is invalid.',
    'in_array'             => 'yang :attribute medan tidak wujud :other.',
    'integer'              => ':attribute mestilah integer.',
    'ip'                   => ':attribute mestilah alamat IP yang sah.',
    'json'                 => ':attribute mestilah rentetan JSON yang sah.',
    'max'                  => [
        'numeric' => ':attribute mungkin tidak lebih besar daripada :max.',
        'file'    => ':attribute mungkin tidak lebih besar daripada :max kilobait.',
        'string'  => ':attribute mungkin tidak lebih besar daripada :max aksara.',
        'array'   => ':attribute mungkin tidak mempunyai lebih daripada :max perkara.',
    ],
    'mimes'                => ':attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute mesti mempunyai sekurang-kurangnya :min.',
        'file'    => ':attribute mesti mempunyai sekurang-kurangnya :min kilobait.',
        'string'  => ':attribute mesti mempunyai sekurang-kurangnya :min aksara.',
        'array'   => ':attribute mesti mempunyai sekurang-kurangnya :min perkara.',
    ],
    'not_in'               => 'Yang dipilih :attribute tidak sah.',
    'numeric'              => ':attribute mestilah nombor.',
    'present'              => 'yang :attribute medan mesti hadir.',
    'regex'                => ':attribute format tidak sah.',
    'required'             => ':attribute medan diperlukan.',
    'required_if'          => ':attribute medan diperlukan apabila :other is :value.',
    'required_unless'      => 'yang :attribute medan diperlukan melainkan :other berada dalam :values.',
    'required_with'        => ':attribute medan diperlukan apabila :values hadir.',
    'required_with_all'    => ':attribute medan diperlukan apabila :values hadir.',
    'required_without'     => ':attribute medan diperlukan apabila :values tidak hadir.',
    'required_without_all' => ':attribute medan diperlukan apabila tiada :values hadir.',
    'same'                 => ':attribute dan :other mesti sepadan.',
    'size'                 => [
        'numeric' => ':attribute mesti :size.',
        'file'    => ':attribute mesti :size kilobait.',
        'string'  => ':attribute mesti :size aksara.',
        'array'   => ':attribute mesti mengandungi :size perkara.',
    ],
    'string'               => ':attribute mesti tali.',
    'timezone'             => ':attribute mestilah zon yang sah.',
    'unique'               => ':attribute telah diambil.',
    'url'                  => ':attribute format tidak sah.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        //
    ],

];

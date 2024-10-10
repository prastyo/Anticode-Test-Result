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

    'accepted' => '此字段必须被接受。',
    'accepted_if' => '当 :other 为 :value 时，此字段必须被接受。',
    'active_url' => '此字段必须是有效的 URL。',
    'after' => '此字段必须是 :date 之后的日期。',
    'after_or_equal' => '此字段必须是 :date 之后或相等的日期。',
    'alpha' => '此字段只能包含字母。',
    'alpha_dash' => '此字段只能包含字母、数字、破折号和下划线。',
    'alpha_num' => '此字段只能包含字母和数字。',
    'array' => '此字段必须是一个数组。',
    'ascii' => '此字段只能包含单字节的字母数字和符号。',
    'before' => '此字段必须是 :date 之前的日期。',
    'before_or_equal' => '此字段必须是 :date 之前或相等的日期。',
    'between' => [
        'array' => '此字段必须包含 :min 到 :max 个项目。',
        'file' => '此字段必须在 :min 到 :max 千字节之间。',
        'numeric' => '此字段必须在 :min 到 :max 之间。',
        'string' => '此字段必须在 :min 到 :max 个字符之间。',
    ],
    'boolean' => '此字段必须是 true 或 false。',
    'can' => '此字段包含无效的值。',
    'confirmed' => '确认不匹配。',
    'contains' => '此字段缺少所需的值。',
    'current_password' => '密码不正确。',
    'date' => '此字段必须是有效的日期。',
    'date_equals' => '此字段必须等于 :date 的日期。',
    'date_format' => '此字段必须与 :format 格式匹配。',
    'decimal' => '此字段必须具有 :decimal 位小数。',
    'declined' => '此字段必须被拒绝。',
    'declined_if' => '当 :other 为 :value 时，此字段必须被拒绝。',
    'different' => '此字段和 :other 必须不同。',
    'digits' => '此字段必须是 :digits 位数。',
    'digits_between' => '此字段必须在 :min 到 :max 位数之间。',
    'dimensions' => '此字段的图像尺寸无效。',
    'distinct' => '此字段有重复的值。',
    'doesnt_end_with' => '此字段不能以 :values 之一结尾。',
    'doesnt_start_with' => '此字段不能以 :values 之一开头。',
    'email' => '此字段必须是有效的电子邮件地址。',
    'ends_with' => '此字段必须以 :values 之一结尾。',
    'enum' => '选定的值无效。',
    'exists' => '选定的值无效。',
    'extensions' => '此字段必须具有以下扩展名：:values。',
    'file' => '此字段必须是文件。',
    'filled' => '此字段必须有值。',
    'gt' => [
        'array' => '此字段必须包含超过 :value 个项目。',
        'file' => '此字段必须大于 :value 千字节。',
        'numeric' => '此字段必须大于 :value。',
        'string' => '此字段必须大于 :value 个字符。',
    ],
    'gte' => [
        'array' => '此字段必须包含至少 :value 个项目。',
        'file' => '此字段必须大于或等于 :value 千字节。',
        'numeric' => '此字段必须大于或等于 :value。',
        'string' => '此字段必须大于或等于 :value 个字符。',
    ],
    'hex_color' => '此字段必须是有效的十六进制颜色。',
    'image' => '此字段必须是图像。',
    'in' => '选定的值无效。',
    'in_array' => '此字段必须在 :other 中。',
    'integer' => '此字段必须是整数。',
    'ip' => '此字段必须是有效的 IP 地址。',
    'ipv4' => '此字段必须是有效的 IPv4 地址。',
    'ipv6' => '此字段必须是有效的 IPv6 地址。',
    'json' => '此字段必须是有效的 JSON 字符串。',
    'list' => '此字段必须是列表。',
    'lowercase' => '此字段必须是小写字母。',
    'lt' => [
        'array' => '此字段必须包含少于 :value 个项目。',
        'file' => '此字段必须小于 :value 千字节。',
        'numeric' => '此字段必须小于 :value。',
        'string' => '此字段必须小于 :value 个字符。',
    ],
    'lte' => [
        'array' => '此字段必须包含不超过 :value 个项目。',
        'file' => '此字段必须小于或等于 :value 千字节。',
        'numeric' => '此字段必须小于或等于 :value。',
        'string' => '此字段必须小于或等于 :value 个字符。',
    ],
    'mac_address' => '此字段必须是有效的 MAC 地址。',
    'max' => [
        'array' => '此字段不得包含超过 :max 个项目。',
        'file' => '此字段不得大于 :max 千字节。',
        'numeric' => '此字段不得大于 :max。',
        'string' => '此字段不得大于 :max 个字符。',
    ],
    'max_digits' => '此字段不得超过 :max 位数。',
    'mimes' => '此字段必须是以下类型的文件：:values。',
    'mimetypes' => '此字段必须是以下类型的文件：:values。',
    'min' => [
        'array' => '此字段必须至少包含 :min 个项目。',
        'file' => '此字段必须至少为 :min 千字节。',
        'numeric' => '此字段必须至少为 :min。',
        'string' => '此字段必须至少为 :min 个字符。',
    ],
    'min_digits' => '此字段必须至少是 :min 位数。',
    'missing' => '此字段必须缺失。',
    'missing_if' => '当 :other 为 :value 时，此字段必须缺失。',
    'missing_unless' => '除非 :other 为 :value，否则此字段必须缺失。',
    'missing_with' => '当存在 :values 时，此字段必须缺失。',
    'missing_with_all' => '当存在 :values 时，此字段必须缺失。',
    'multiple_of' => '此字段必须是 :value 的倍数。',
    'not_in' => '选定的值无效。',
    'not_regex' => '此字段的格式无效。',
    'numeric' => '此字段必须是数字。',
    'password' => [
        'letters' => '此字段必须包含至少一个字母。',
        'mixed' => '此字段必须包含至少一个大写字母和一个小写字母。',
        'numbers' => '此字段必须包含至少一个数字。',
        'symbols' => '此字段必须包含至少一个符号。',
        'uncompromised' => '提供的值已在数据泄露中被发现。请选择其他值。',
    ],
    'present' => '此字段必须存在。',
    'present_if' => '当 :other 为 :value 时，此字段必须存在。',
    'present_unless' => '除非 :other 为 :value，否则此字段必须存在。',
    'present_with' => '当存在 :values 时，此字段必须存在。',
    'present_with_all' => '当存在 :values 时，此字段必须存在。',
    'prohibited' => '此字段是被禁止的。',
    'prohibited_if' => '当 :other 为 :value 时，此字段是被禁止的。',
    'prohibited_unless' => '除非 :other 包含在 :values 中，否则此字段是被禁止的。',
    'prohibits' => '此字段禁止 :other 的存在。',
    'regex' => '此字段的格式无效。',
    'required' => '此字段是必填的。',
    'required_array_keys' => '此字段必须包含 :values 的项目。',
    'required_if' => '当 :other 为 :value 时，此字段是必填的。',
    'required_if_accepted' => '当 :other 被接受时，此字段是必填的。',
    'required_if_declined' => '当 :other 被拒绝时，此字段是必填的。',
    'required_unless' => '除非 :other 包含在 :values 中，否则此字段是必填的。',
    'required_with' => '当存在 :values 时，此字段是必填的。',
    'required_with_all' => '当存在 :values 时，此字段是必填的。',
    'required_without' => '当 :values 缺失时，此字段是必填的。',
    'required_without_all' => '当所有 :values 缺失时，此字段是必填的。',
    'same' => '此字段必须与 :other 匹配。',
    'size' => [
        'array' => '此字段必须包含 :size 个项目。',
        'file' => '此字段必须为 :size 千字节。',
        'numeric' => '此字段必须为 :size。',
        'string' => '此字段必须为 :size 个字符。',
    ],
    'starts_with' => '此字段必须以 :values 之一开头。',
    'string' => '此字段必须是字符串。',
    'timezone' => '此字段必须是有效的时区。',
    'unique' => '此值已经被使用。',
    'uploaded' => '上传此字段失败。',
    'uppercase' => '此字段必须为大写字母。',
    'url' => '此字段必须是有效的 URL。',
    'ulid' => '此字段必须是有效的 ULID。',
    'uuid' => '此字段必须是有效的 UUID。',

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

    'alpha_numeric_space_quote_dot' => '此字段只能包含字母、数字、空格、引号和句点。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

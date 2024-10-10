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

    'accepted' => '이 필드는 승인되어야 합니다.',
    'accepted_if' => '이 필드는 :other 이 :value 일 때 승인되어야 합니다.',
    'active_url' => '이 필드는 유효한 URL이어야 합니다.',
    'after' => '이 필드는 :date 이후의 날짜여야 합니다.',
    'after_or_equal' => '이 필드는 :date 이후 또는 같은 날짜여야 합니다.',
    'alpha' => '이 필드는 문자만 포함할 수 있습니다.',
    'alpha_dash' => '이 필드는 문자, 숫자, 대시, 밑줄만 포함할 수 있습니다.',
    'alpha_num' => '이 필드는 문자와 숫자만 포함할 수 있습니다.',
    'array' => '이 필드는 배열이어야 합니다.',
    'ascii' => '이 필드는 단일 바이트의 영숫자 및 기호만 포함해야 합니다.',
    'before' => '이 필드는 :date 이전의 날짜여야 합니다.',
    'before_or_equal' => '이 필드는 :date 이전 또는 같은 날짜여야 합니다.',
    'between' => [
        'array' => '이 필드는 :min에서 :max 항목 사이여야 합니다.',
        'file' => '이 필드는 :min에서 :max 킬로바이트 사이여야 합니다.',
        'numeric' => '이 필드는 :min 에서 :max 사이여야 합니다.',
        'string' => '이 필드는 :min 에서 :max 글자 사이여야 합니다.',
    ],
    'boolean' => '이 필드는 true 또는 false여야 합니다.',
    'can' => '이 필드는 허용되지 않은 값을 포함하고 있습니다.',
    'confirmed' => '확인이 일치하지 않습니다.',
    'contains' => '이 필드에 필요한 값이 누락되었습니다.',
    'current_password' => '비밀번호가 잘못되었습니다.',
    'date' => '이 필드는 유효한 날짜여야 합니다.',
    'date_equals' => '이 필드는 :date 와 같은 날짜여야 합니다.',
    'date_format' => '이 필드는 :format 형식과 일치해야 합니다.',
    'decimal' => '이 필드는 :decimal 소수 자릿수를 가져야 합니다.',
    'declined' => '이 필드는 거부되어야 합니다.',
    'declined_if' => '이 필드는 :other 이 :value일 때 거부되어야 합니다.',
    'different' => '이 필드와 :other 는 달라야 합니다.',
    'digits' => '이 필드는 :digits 자릿수여야 합니다.',
    'digits_between' => '이 필드는 :min 에서 :max 자릿수 사이여야 합니다.',
    'dimensions' => '이 필드는 잘못된 이미지 크기를 가지고 있습니다.',
    'distinct' => '이 필드에 중복된 값이 있습니다.',
    'doesnt_end_with' => '이 필드는 :values 중 하나로 끝나지 않아야 합니다.',
    'doesnt_start_with' => '이 필드는 :values 중 하나로 시작하지 않아야 합니다.',
    'email' => '이 필드는 유효한 이메일 주소여야 합니다.',
    'ends_with' => '이 필드는 :values 중 하나로 끝나야 합니다.',
    'enum' => '선택된 값이 유효하지 않습니다.',
    'exists' => '선택된 값이 유효하지 않습니다.',
    'extensions' => '이 필드는 다음 확장자를 가져야 합니다: :values.',
    'file' => '이 필드는 파일이어야 합니다.',
    'filled' => '이 필드에는 값이 있어야 합니다.',
    'gt' => [
        'array' => '이 필드에는 :value개 이상의 항목이 있어야 합니다.',
        'file' => '이 필드는 :value 킬로바이트보다 커야 합니다.',
        'numeric' => '이 필드는 :value 보다 커야 합니다.',
        'string' => '이 필드는 :value 글자보다 커야 합니다.',
    ],
    'gte' => [
        'array' => '이 필드에는 :value 개 이상의 항목이 있어야 합니다.',
        'file' => '이 필드는 :value 킬로바이트 이상이어야 합니다.',
        'numeric' => '이 필드는 :value 이상이어야 합니다.',
        'string' => '이 필드는 :value 글자 이상이어야 합니다.',
    ],
    'hex_color' => '이 필드는 유효한 16진수 색상이어야 합니다.',
    'image' => '이 필드는 이미지여야 합니다.',
    'in' => '선택된 값이 유효하지 않습니다.',
    'in_array' => '이 필드는 :other 에 있어야 합니다.',
    'integer' => '이 필드는 정수여야 합니다.',
    'ip' => '이 필드는 유효한 IP 주소여야 합니다.',
    'ipv4' => '이 필드는 유효한 IPv4 주소여야 합니다.',
    'ipv6' => '이 필드는 유효한 IPv6 주소여야 합니다.',
    'json' => '이 필드는 유효한 JSON 문자열이어야 합니다.',
    'list' => '이 필드는 목록이어야 합니다.',
    'lowercase' => '이 필드는 소문자여야 합니다.',
    'lt' => [
        'array' => '이 필드는 :value 개 미만의 항목을 가져야 합니다.',
        'file' => '이 필드는 :value 킬로바이트보다 작아야 합니다.',
        'numeric' => '이 필드는 :value 보다 작아야 합니다.',
        'string' => '이 필드는 :value 글자보다 작아야 합니다.',
    ],
    'lte' => [
        'array' => '이 필드는 :value 개 이하의 항목을 가져야 합니다.',
        'file' => '이 필드는 :value 킬로바이트 이하이어야 합니다.',
        'numeric' => '이 필드는 :value 이하이어야 합니다.',
        'string' => '이 필드는 :value 글자 이하이어야 합니다.',
    ],
    'mac_address' => '이 필드는 유효한 MAC 주소여야 합니다.',
    'max' => [
        'array' => '이 필드는 :max 개 이상의 항목을 가져서는 안 됩니다.',
        'file' => '이 필드는 :max 킬로바이트보다 커서는 안 됩니다.',
        'numeric' => '이 필드는 :max 보다 커서는 안 됩니다.',
        'string' => '이 필드는 :max 글자보다 커서는 안 됩니다.',
    ],
    'max_digits' => '이 필드는 :max 자릿수 이상일 수 없습니다.',
    'mimes' => '이 필드는 다음 유형의 파일이어야 합니다: :values.',
    'mimetypes' => '이 필드는 다음 유형의 파일이어야 합니다: :values.',
    'min' => [
        'array' => '이 필드는 최소한 :min 개의 항목을 가져야 합니다.',
        'file' => '이 필드는 최소 :min 킬로바이트이어야 합니다.',
        'numeric' => '이 필드는 최소 :min 이어야 합니다.',
        'string' => '이 필드는 최소 :min 글자이어야 합니다.',
    ],
    'min_digits' => '이 필드는 최소 :min 자릿수여야 합니다.',
    'missing' => '이 필드는 없어야 합니다.',
    'missing_if' => ':other 가 :value 일 때 이 필드는 없어야 합니다.',
    'missing_unless' => ':other 가 :value 가 아닐 경우 이 필드는 없어야 합니다.',
    'missing_with' => ':values 가 있을 때 이 필드는 없어야 합니다.',
    'missing_with_all' => ':values 가 있을 때 이 필드는 없어야 합니다.',
    'multiple_of' => '이 필드는 :value 의 배수여야 합니다.',
    'not_in' => '선택된 값이 유효하지 않습니다.',
    'not_regex' => '이 필드의 형식이 잘못되었습니다.',
    'numeric' => '이 필드는 숫자여야 합니다.',
    'password' => [
        'letters' => '이 필드에는 적어도 하나의 문자가 포함되어야 합니다.',
        'mixed' => '이 필드에는 적어도 하나의 대문자와 소문자가 포함되어야 합니다.',
        'numbers' => '이 필드에는 적어도 하나의 숫자가 포함되어야 합니다.',
        'symbols' => '이 필드에는 적어도 하나의 기호가 포함되어야 합니다.',
        'uncompromised' => '제공된 값은 데이터 유출에서 발견되었습니다. 다른 값을 선택하십시오.',
    ],
    'present' => '이 필드는 존재해야 합니다.',
    'present_if' => ':other 가 :value 일 때 이 필드는 존재해야 합니다.',
    'present_unless' => ':other 가 :value 가 아닐 경우 이 필드는 존재해야 합니다.',
    'present_with' => ':values 가 있을 때 이 필드는 존재해야 합니다.',
    'present_with_all' => ':values 가 있을 때 이 필드는 존재해야 합니다.',
    'prohibited' => '이 필드는 금지되어 있습니다.',
    'prohibited_if' => ':other가 :value 일 때 이 필드는 금지되어 있습니다.',
    'prohibited_unless' => ':other 가 :values 에 포함되지 않으면 이 필드는 금지되어 있습니다.',
    'prohibits' => '이 필드는 :other 의 존재를 금지합니다.',
    'regex' => '이 필드의 형식이 잘못되었습니다.',
    'required' => '이 필드는 필수 항목입니다.',
    'required_array_keys' => '이 필드에는 :values 에 대한 항목이 포함되어 있어야 합니다.',
    'required_if' => ':other 가 :value 일 때 이 필드는 필수입니다.',
    'required_if_accepted' => '가 승인되었을 때 이 필드는 필수입니다.',
    'required_if_declined' => '가 거부되었을 때 이 필드는 필수입니다.',
    'required_unless' => '가 에 포함되지 않으면 이 필드는 필수입니다.',
    'required_with' => '가 있을 때 이 필드는 필수입니다.',
    'required_with_all' => '가 있을 때 이 필드는 필수입니다.',
    'required_without' => '가 없을 때 이 필드는 필수입니다.',
    'required_without_all' => '모든 가 없을 때 이 필드는 필수입니다.',
    'same' => '이 필드는 와 일치해야 합니다.',
    'size' => [
        'array' => '이 필드는 개의 항목을 포함해야 합니다.',
        'file' => '이 필드는 킬로바이트이어야 합니다.',
        'numeric' => '이 필드는 이어야 합니다.',
        'string' => '이 필드는 글자여야 합니다.',
    ],
    'starts_with' => '이 필드는 다음 중 하나로 시작해야 합니다:values.',
    'string' => '이 필드는 문자열이어야 합니다.',
    'timezone' => '이 필드는 유효한 시간대여야 합니다.',
    'unique' => '이 값은 이미 사용되고 있습니다.',
    'uploaded' => '이 필드를 업로드하는 데 실패했습니다.',
    'uppercase' => '이 필드는 대문자여야 합니다.',
    'url' => '이 필드는 유효한 URL이어야 합니다.',
    'ulid' => '이 필드는 유효한 ULID여야 합니다.',
    'uuid' => '이 필드는 유효한 UUID여야 합니다.',

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

    'alpha_numeric_space_quote_dot' => '이 필드 에는 문자, 숫자, 공백 및 따옴표만 포함될 수 있습니다.',

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

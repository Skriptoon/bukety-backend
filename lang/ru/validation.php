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

    'accepted' => ':attribute должен быть принят.',
    'accepted_if' => ':attribute должен быть принят, если :other равно :value.',
    'active_url' => ':attributeне является допустимым URL.',
    'after' => ':attribute должен быть датой после :date.',
    'after_or_equal' => ':attribute должен быть датой после :date или равным :date.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, дефисы и символы подчеркивания.',
    'alpha_num' => ':attribute должен содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'ascii' => ':attribute должен содержать только однобайтовые буквенно-цифровые символы и символы.',
    'before' => ':attribute должен быть датой до :date.',
    'before_or_equal' => ':attribute должен быть датой, предшествующей :date или равной ей.',
    'between' => [
        'array' => ':attribute должен иметь от :min до :max элементов.',
        'file' => ':attribute должен быть между :min и :max килобайтами.',
        'numeric' => ':attribute должен быть между :min и :max.',
        'string' => ':attribute должен находиться между символами :min и :max.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'current_password' => 'Неправильный пароль.',
    'date' => ':attributeне является действительной датой.',
    'date_equals' => ':attribute должен быть датой, равной :date.',
    'date_format' => ':attributeне соответствует формату :format.',
    'decimal' => ':attribute должен иметь :decimal десятичных разрядов.',
    'declined' => ':attribute должен быть отклонен.',
    'declined_if' => ':attribute должен быть отклонен, если :other равно :value.',
    'different' => ':attribute и :other должны быть разными.',
    'digits' => ':attribute должен быть :digits digits.',
    'digits_between' => ':attribute должен быть между цифрами :min и :max.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'doesnt_end_with' => ':attribute не может заканчиваться одним из следующих: :values.',
    'doesnt_start_with' => ':attribute не может начинаться с одного из следующих: :values.',
    'email' => ':attribute должен быть действительным адресом электронной почты.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих: :values.',
    'enum' => 'Выбранный :атрибут недействителен.',
    'exists' => 'Выбранный :атрибут недействителен.',
    'file' => ':attribute должен быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
    ],
    'image' => ':attribute должен быть изображением.',
    'in' => 'Выбранный :атрибут недействителен.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должен быть целым числом.',
    'ip' => ':attribute должен быть действительным IP-адресом.',
    'ipv4' => ':attribute должен быть действительным адресом IPv4.',
    'ipv6' => ':attribute должен быть действительным адресом IPv6.',
    'json' => ':attribute должен быть допустимой строкой JSON.',
    'lowercase' => ':attribute должен быть в нижнем регистре.',
    'lt' => [
        'array' => ':attribute должен содержать меньше элементов :value.',
        'file' => ':attribute должен быть меньше :value килобайт.',
        'numeric' => ':attribute должен быть меньше :value.',
        'string' => ':attribute должен быть меньше символов :value.',
    ],
    'lte' => [
        'array' => ':attribute не должен содержать более :value элементов.',
        'file' => ':attribute должен быть меньше или равен :value килобайтам.',
        'numeric' => ':attribute должен быть меньше или равен :value.',
        'string' => ':attribute должен быть меньше или равен :value символов.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => ':attribute не должен содержать более :max элементов.',
        'file' => ':attribute не должен превышать :max килобайт.',
        'numeric' => ':attribute не должен быть больше :max.',
        'string' => ':attribute не должен превышать :max символов.',
    ],
    'max_digits' => ':attribute не должен содержать более :max цифр.',
    'mimes' => ':attribute должен быть файлом типа: :values.',
    'mimetypes' => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'array' => ':attribute должен содержать не менее :min элементов.',
        'file' => ':attribute должен быть не менее :min килобайт.',
        'numeric' => ':attribute должен быть не меньше :min.',
        'string' => ':attribute должен содержать не менее :min символов.',
    ],
    'min_digits' => ':attribute должен содержать не менее :min цифр.',
    'multiple_of' => ':attribute должен быть кратен :value.',
    'not_in' => 'Выбранный :атрибут недействителен.',
    'not_regex' => 'Недопустимый формат :attribute.',
    'numeric' => ':attribute должен быть числом.',
    'password' => [
        'letters' => ':attribute должен содержать хотя бы одну букву.',
        'mixed' => ':attribute должен содержать хотя бы одну прописную и одну строчную букву.',
        'numbers' => ':attribute должен содержать хотя бы одно число.',
        'symbols' => ':attribute должен содержать хотя бы один символ.',
        'uncompromised' => 'Данный :attribute появился в утечке данных. Пожалуйста, выберите другой :attribute.',
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, если :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает присутствие :other.',
    'regex' => 'Недопустимый формат :attribute.',
    'required' => 'Поле :attribute обязательно.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute обязательно, если :other равно :value.',
    'required_if_accepted' => 'Поле :attribute обязательно, если принимается :other.',
    'required_unless' => 'Поле :attribute является обязательным, если :other не находится в :values.',
    'required_with' => 'Поле :attribute обязательно, если присутствует :values.',
    'required_with_all' => 'Поле :attribute обязательно, если присутствуют :values.',
    'required_without' => 'Поле :attribute является обязательным, если :values отсутствует.',
    'required_without_all' => 'Поле :attribute является обязательным, если ни одно из :value не присутствует.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'array' => ':attribute должен содержать элементы :size.',
        'file' => ':attribute должен быть :size килобайт.',
        'numeric' => ':attribute должен быть :size.',
        'string' => ':attribute должен быть размером :size символов.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих: :values.',
    'string' => ':attribute должен быть строкой.',
    'timezone' => ':attribute должен быть действительным часовым поясом.',
    'unique' => ':attribute уже занят.',
    'uploaded' => 'Не удалось загрузить :attributeattribute.',
    'uppercase' => ':attribute должен быть в верхнем регистре.',
    'url' => ':attribute должен быть действительным URL.',
    'ulid' => ':attribute должен быть действительным ULID.',
    'uuid' => ':attribute должен быть действительным UUID.',

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

    'custom' => [
        'expired' => [
            'required_unless' => 'Поле обязательно, если не указано навсегда',
        ],
    ],

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

    'attributes' => [
    ],
];

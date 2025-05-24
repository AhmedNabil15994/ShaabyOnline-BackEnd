<?php

return [
	/*
		    |--------------------------------------------------------------------------
		    | Validation Language Lines
		    |--------------------------------------------------------------------------
		    |
		    | The following language lines contain the default error messages used by
		    | the validator class. Some of these rules have multiple versions such
		    | such as the size rules. Feel free to tweak each of these messages.
		    |
	*/

	'accepted' => 'يجب قبول :attribute',
	'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا',
	'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
	'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
	'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف',
	'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
	'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
	'array' => 'يجب أن يكون :attribute ًمصفوفة',
	'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
	'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
	'between' => [
		'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
		'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
		'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
		'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
	],
	'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false ',
	'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
	'date' => ':attribute ليس تاريخًا صحيحًا',
	'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
	'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
	'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام',
	'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام ',
	'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
	'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
	'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
	'exists' => ':attribute غير مسجل لدينا',
	'file' => 'الـ :attribute يجب أن يكون ملفا.',
	'filled' => ':attribute إجباري',
	'image' => 'يجب أن يكون :attribute صورةً',
	'in' => ' (:values) غير موجود ف الاختيارات ',
	'in_array' => ':attribute غير موجود في :other.',
	'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
	'ip' => 'يجب أن يكون :attribute عنوان IP صحيحًا',
	'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
	'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
	'json' => 'يجب أن يكون :attribute نصآ من نوع JSON.',
	'max' => [
		'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر لـ :max.',
		'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
		'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
		'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
	],
	'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
	'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
	'min' => [
		'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر لـ :min.',
		'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
		'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
		'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
	],
	'not_in' => ':attribute لاغٍ',
	'numeric' => 'يجب على :attribute أن يكون رقمًا',
	'present' => 'يجب تقديم :attribute',
	'regex' => 'صيغة :attribute غير صحيحة',
	'required' => ':attribute مطلوب ',
	'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
	'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
	'required_with' => ':attribute مطلوب إذا توفّر :values.',
	'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
	'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
	'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
	'same' => 'يجب أن يتطابق :attribute مع :other',
	'size' => [
		'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
		'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
		'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
		'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
	],
	'string' => 'يجب أن يكون :attribute نصآ.',
	'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
	'unique' => 'قيمة :attribute مُستخدمة من قبل',
	'uploaded' => 'فشل في تحميل الـ :attribute',
	'url' => 'صيغة الرابط :attribute غير صحيحة',

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
		"question.ar" => [
			"required" => "السؤال باللغه العربيه",
		],
		"question.en" => [
			"required" => "السؤال باللغه الانجليزيه",
		],
		"answer.en" => [
			"required" => "الاجابه باللغه الانجليزيه",
		],
		"answer.ar" => [
			"required" => "الاجابه باللغه العربيه",
		],
		'socials.*.type' => [
			'exists' => 'نوع تواصل الاجتماعى غير مسجل لدينا',

		],
		'socials.*.link' => [
			'url' => ' صيغة الرابط غير صحيحه',
		],
		"hashtag.*" => [
			"required" => "قيم الهاشتاجات مطلوبه"
		],
		"mentions.*" => [
			"required" => "قيم المزكور مطلوبه"
		],
		"mentions.*" => [
			"required" => "قيم المزكور مطلوبه"
		],
		"title.ar" => [
			"required" => " العنوان باللغه العربيه مطلوب",
			"max"	   => "العنوان باللغه العربيه يجب ان يكون بحد اقصى 255"
		],
		"description.ar" => [
			"required" => " الوصف باللغه العربيه مطلوب",
		],
		"description.en" => [
			"required" => " الوصف باللغه الانجليزيه مطلوب",
		],
		"title.en" => [
			"required" => " العنوان باللغه الانجليزيه مطلوب",
			"max"	   => "العنوان باللغه الانجليزيه يجب ان يكون بحد اقصى 255"
		],
		"tags.*" => [
			"required" => "قيم العلامات مطلوبه"
		],
		"socials.*.key" => [
			'exists' => 'نوع تواصل الاجتماعى غير مسجل لدينا',
		],
		"socials.*.link" => [
			'required' => 'الرابط مطلوب ',
		],
		"socials.*.social_id" => [
			'exists' => 'وسيلة تواصل الاجتماعى غير مسجل لدينا',
			"required" => "وسيلة التواصل مطلوبه"
		],
		"socials.*.social_option_id" => [
			'exists' => 'خيارات وسيلة  تواصل الاجتماعى غير مسجل لدينا ',
			"required" => "خيارات وسيلة  التواصل مطلوبه "
		],
		"bank.user_name" => [
			"required" => "اسم صاحب الحسا ب مطلوب",
			"max"	   => "اقصى عدد للحروف 255 ",

		],
		"bank.account_number" => [
			"required" => "رقم الحساب مطلوب ",
			"max"	   => "اقصى عدد للحروف 255 ",
			"numeric" => "يجب ان يكون ارقام"
		],
		"bank.address" => [
			"required" => "العنوان لصاحب الحساب مطلوب",
			"max"	   => "اقصى عدد للحروف 255 ",
			"numeric" => ""
		],
		"bank.iban" => [
			"required" => "رقم الابيان مطلوب",
			"max"	   => "اقصى عدد للحروف 255 ",
			"numeric" => "يجب ان يكون ارقام"
		],
		"bank.bank_name" => [
			"required" => "اسم البنك مطلوب ",
			"max"	   => "اقصى عدد للحروف 255 ",
			"numeric" => ""
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

	'attributes' => [

		'message' => 'محتوى الرسالة',
		"option.*.ar" => "  احدى الخيارات بالغة العربيه",
		"option.*.en" => " احدى الخيارات باللغة الانجليزيه ",
		"price.*" => " احدى الاسعار",

		'address'               => 'العنوان',
		'age'                   => 'العمر',
		'available'             => 'مُتاح',
		'city'                  => 'المدينة',
		'content'               => 'المُحتوى',
		'country'               => 'الدولة',
		'date'                  => 'التاريخ',
		'day'                   => 'اليوم',
		'description'           => 'الوصف',
		'email'                 => 'البريد الالكتروني',
		'excerpt'               => 'المُلخص',
		'first_name'            => 'الاسم الأول',
		'gender'                => 'النوع',
		'hour'                  => 'ساعة',
		'last_name'             => 'اسم العائلة',
		'minute'                => 'دقيقة',
		'mobile'                => 'الجوال',
		'month'                 => 'الشهر',
		'name'                  => 'الاسم',
		'password'              => 'كلمة المرور',
		'password_confirmation' => 'تأكيد كلمة المرور',
		'phone'                 => 'الهاتف',
		'second'                => 'ثانية',
		'sex'                   => 'الجنس',
		'size'                  => 'الحجم',
		'time'                  => 'الوقت',
		'title'                 => 'العنوان',
		'username'              => 'اسم المُستخدم',
		'year'                  => 'السنة',
		'address_id'            => 'رقم العنوان',
		'calling_code'          => 'مفتاح الدولة',
		'mobile'                => 'رقم الهاتف',
		'address.*'             => 'العنوان باللغات',
		'rating'                => 'قيمة التقييم',
		'comment'               => 'التعليق او الملاحظة',
		'price'                 => 'السعر',
		'qty'                   => 'الكمية',
		'product_flag'          => 'نوع المنتج',

		'link' 					=> 'الرابط',
		'user_id' 		      	=> 'العضو',
		'state' 		      	=> 'المنطقة',
		'cover' 		      	=> 'صورة الغلاف',

		'vendors' 		      	=> 'المتاجر',
		'vendor' 		      	=> 'المتجر',
		'vendor_id' 		    => 'المتجر',
		'category_id' 		    => 'القسم',
		'product_id' 		    => 'المنتج',
		'display_type' 		    => 'طريقة العرض',
		'grid_columns_count'    => 'عدد الإعمدة',
		'type' 		    		=> 'النوع',

		'payment_data.charges' => 'قيمة charges',
		'payment_data.cc_charges' => 'قيمة cc charges',
		'payment_data.ibans' => 'IBAN',

		'payment_data.fixed_app_commission' => 'العمولة (مبلغ)',
		'payment_data.percentage_app_commission' => 'العمولة (نسبة مئوية %)',

		'fixed_app_commission' => 'عمولة بوابة الدفع (مبلغ)',
		'percentage_app_commission' => 'عمولة بوابة الدفع (نسبة مئوية %)',

		'delivery_time_types'   => 'آلية وقت التوصيل',
		'shipping'        		=> 'وقت التوصيل',
		'shipping.type'        	=> 'وقت التوصيل',
	],
];

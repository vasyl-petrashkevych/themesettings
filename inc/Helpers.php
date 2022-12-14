<?php

namespace ThemeSettings {
	class Helpers {
		public const TEXT_DOMAIN     = 'themeoptions';
		public const FILTER          = 'theme_options_errors';
		public const TEMPLATE_ERRORS = 'template_errors';
		public const README_LINK     = 'https://github.com/vasyl-petrashkevych/themeoptions/blob/main/README.md';

		public static function __( $test ): ?string {
			return __( $test, self::TEXT_DOMAIN );
		}

		public static function generate_option_name( string $slug ): string {
			return self::TEXT_DOMAIN . '_' . $slug;
		}

		public static function generate_values(array $data): string {
			$response = [];
				foreach ($data as $key => $value) {
					$response[explode( '_', $key )[1]] = $value;
				}
			return json_encode($response);
		}
	}
}
<?php

declare(strict_types=1);

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true)
    ->setRules([
        '@PHP81Migration'                   => true,
        '@PSR2'                             => true,
        'psr_autoloading'                   => true,
        'strict_param'                      => true,
        'declare_strict_types'              => true,
        'fully_qualified_strict_types'      => true,
        'single_quote'                      => true,
        'linebreak_after_opening_tag'       => true,
        'logical_operators'                 => true,
        'lowercase_cast'                    => true,
        'short_scalar_cast'                 => true,
        'no_whitespace_in_blank_line'       => true,
        'no_unused_imports'                 => true,
        'combine_consecutive_issets'        => true,
        'not_operator_with_successor_space' => true,
        'combine_consecutive_unsets'        => true,
        'native_function_casing'            => true,
        'native_function_invocation'        => true,
        'no_alias_functions'                => true,
        'trailing_comma_in_multiline'       => true,
        'mb_str_functions'                  => true,
        'ternary_to_null_coalescing'        => true,
        'random_api_migration'              => true,
        'void_return'                       => true,
        'static_lambda'                     => true,
        'strict_comparison'                 => true,
        'visibility_required'               => [
            'elements' => [
                'property',
                'method',
                'const',
            ],
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
        ],
        'return_type_declaration' => [
            'space_before' => 'none',
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const'        => 'only_if_meta',
                'method'       => 'one',
                'property'     => 'one',
                'trait_import' => 'none',
                'case'         => 'none',
            ],
        ],
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'concat_space' => [
            'spacing' => 'none',
        ],
    ]);

return $config;

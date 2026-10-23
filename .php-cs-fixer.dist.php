<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

// do not enable self_accessor as it breaks opendxp models relying on get_called_class()
return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR1'        => true,
        '@PSR2'        => true,
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax'  => ['syntax' => 'short'],

        'blank_line_before_statement'         => true,
        'encoding'                            => true,
        'type_declaration_spaces'             => true,
        'single_line_comment_style'           => true,
        'lowercase_cast'                      => true,
        'magic_constant_casing'               => true,
        'method_argument_space'               => [
            'on_multiline' => 'ignore',
        ],
        'class_attributes_separation'         => true,
        'native_function_casing'              => true,
        'no_blank_lines_after_class_opening'  => true,
        'no_blank_lines_after_phpdoc'         => true,
        'no_empty_comment'                    => true,
        'no_empty_phpdoc'                     => true,
        'no_empty_statement'                  => true,
        'no_extra_blank_lines'                => true,
        'no_leading_import_slash'             => true,
        'no_leading_namespace_whitespace'     => true,
        'no_short_bool_cast'                  => true,
        'no_spaces_around_offset'             => true,
        'no_superfluous_phpdoc_tags'          => [
            'allow_mixed'       => true,
            'remove_inheritdoc' => true,
        ],
        'no_unneeded_control_parentheses'     => true,
        'no_unused_imports'                   => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line'         => true,
        'object_operator_without_whitespace'  => true,
        'phpdoc_indent'                       => true,
        'phpdoc_no_useless_inheritdoc'        => true,
        'phpdoc_scalar'                       => true,
        'phpdoc_separation'                   => true,
        'phpdoc_single_line_var_spacing'      => true,
        'phpdoc_trim'                         => true,
        'return_type_declaration'             => true,
        'short_scalar_cast'                   => true,
        'blank_lines_before_namespace'        => true,
        'single_quote'                        => true,
        'space_after_semicolon'               => true,
        'standardize_not_equals'              => true,
        'ternary_operator_spaces'             => true,
        'trailing_comma_in_multiline'         => true,
        'whitespace_after_comma_in_array'     => true,
        'multiline_promoted_properties'       => [
            'minimum_number_of_parameters' => 2,
        ],
        'global_namespace_import'             => [
            'import_classes'   => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'ordered_imports'                     => [
            'imports_order' => ['const', 'class', 'function'],
        ],
        'ordered_attributes'                  => true,
    ])
    ->setFinder($finder);

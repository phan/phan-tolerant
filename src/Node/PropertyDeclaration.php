<?php
/*---------------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/

namespace Microsoft\PhpParser\Node;

use Microsoft\PhpParser\MissingToken;
use Microsoft\PhpParser\ModifiedTypeInterface;
use Microsoft\PhpParser\ModifiedTypeTrait;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\DelimitedList\PropertyElementList;
use Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Microsoft\PhpParser\Token;

class PropertyDeclaration extends Node implements ModifiedTypeInterface {
    use ModifiedTypeTrait;

    /** @var AttributeGroup[]|null */
    public $attributes;

    /** @var Token|null asymmetric visibility for set operations (PHP 8.4+) */
    public $setVisibilityToken;

    /** @var Token|null question token for PHP 7.4 type declaration */
    public $questionToken;

    /** @var QualifiedNameList|MissingToken|null */
    public $typeDeclarationList;

    /** @var PropertyElementList */
    public $propertyElements;

    /** @var Token */
    public $semicolon;

    const CHILD_NAMES = [
        'attributes',
        'modifiers',
        'setVisibilityToken',
        'questionToken',
        'typeDeclarationList',
        'propertyElements',
        'semicolon'
    ];
}

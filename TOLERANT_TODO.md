# Tolerant Parser Update TODO

## Overview

This branch tracks work needed to bring the tolerant PHP parser up to date for PHP 8.3, 8.4, and 8.5 so that downstream consumers (notably Phan) can rely on it when the native `ext-ast` extension is unavailable. The fork currently matches upstream commit `457738cbe` (September 2024) and is missing several recent language features.

## Current Status

- PHPUnit suites `invariants` and `api` pass locally when run with `zend.assertions=1` and `assert.exception=1`.
- Grammar fixtures (`tests/cases/parser*.tree/.diag`) were generated before the latest language changes; they will need regeneration once parser updates land.
- Validation tests that depend on large submodules (`validation/frameworks/*`) remain skipped/not vendored.

## Gaps / Work Items

### PHP 8.3

Most 8.3 constructs parse, but we should explicitly verify:

- `readonly` refinements (interfaces, class constants) – ensure new modifiers propagate through `Parser` and AST classes.
- Enum improvements (interface inheritance rules, optional `implements` lists) – confirm grammar and diagnostics still match php-src.
- Property initialisers inside `readonly` classes behave the same as php-ast output.

### PHP 8.4

- **Property hooks** (`public int $count { get => $this->value; set { ... } }`).
  - Extend the tokenizer/grammar so `get`/`set` in this context become dedicated tokens (not identifiers).
  - Update AST node classes to represent hook lists and bodies.
  - Adjust diagnostics and tolerant AST converter (in Phan) to populate the `hooks` child.
- New attribute placements (e.g. attributes on `class const`, hook blocks) must be accepted and serialized.
- `readonly` class improvements and intersection types: confirm parser emits the correct flags and up-to-date diagnostics.

### PHP 8.5 (in progress)

Monitor RFCs merged into php-src and mirror the token/grammar changes, for example:

- Asymmetric property visibility.
- Additional keywords or attribute positions.
- New `T_*` tokens introduced in php-src; update `TokenKind.php` and `TokenStringMaps.php` accordingly.

### Diagnostics & Node Mapping

- Review `TokenKind`/`TokenStringMaps` for completeness after adding new tokens.
- Ensure node classes record line/column spans needed by language-server features when hooks and new constructs are present.
- Verify edits still map correctly (`TextEdit`, node mapping) for newly supported syntax.

### Tests & Tooling

- Add focused fixtures for property hooks and any new constructs under `tests/cases/parser` (and regenerate `.tree/.diag`).
- Re-enable / update tolerant PHPUnit suites once fixtures are refreshed.
- Consider syncing targeted tests from Phan’s fallback suite to catch divergences early.

### Integration with Phan

- After implementing features, run Phan’s fallback parser tests (`./tests/run_test __FakeSelfFallbackTest`) to ensure parity.
- Publish updated tags / commit references so Phan can subtree merge the changes into `third_party/phan-tolerant`.

## Next Steps

1. Audit existing fixtures vs php-src 8.3/8.4 syntax to catalogue precise failures.
2. Prototype grammar/tokenizer changes for property hooks and regenerate associated AST nodes.
3. Update diagnostics and tolerant AST converter expectations in tandem with Phan.
4. Refresh fixtures and CI to cover the new syntax.
5. Coordinate subtree sync back into Phan once tests pass.


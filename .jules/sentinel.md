## 2025-02-26 - [Path Traversal in File Renaming]
**Vulnerability:** User-controlled identifiers (like `employee_id`) were used to construct file paths for `rename()` operations, allowing attackers to move files outside the intended directory.
**Learning:** Using `basename()` is a good first step, but not sufficient if the base directory itself isn't verified. Combining `realpath()` and `str_starts_with()` ensures the resulting path is within the expected root.
**Prevention:** Always sanitize identifiers used in file paths with `alpha_dash` validation and verify the final path destination using `realpath` checks against a trusted base directory.

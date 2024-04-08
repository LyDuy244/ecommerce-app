<?php

namespace App\Rules;

use App\Models\PostCatalogue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class checkPostCatalogueChildrenRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $postCatalogue = PostCatalogue::find($value);
        if (empty($postCatalogue)) {
            $fail("Khong the xoa danh muc khong ton tai");
        } else if ($postCatalogue->rgt - $postCatalogue->lft > 1) {
            $fail("Khong the xoa danh muc co chua danh muc con");
        }
    }
}

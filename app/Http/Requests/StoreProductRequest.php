<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\AuditLogHelper;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // allow all authenticated users to create/update
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value && !$this->validateMalware($value)) {
                        $fail("Upload blocked: file contains unsafe code.");
                    }
                }
            ],
        ];
    }


    public function validateMalware($file)
    {
        // Read file content
        $contents = file_get_contents($file->getRealPath());

        // Known bad signatures
        $bad_signatures = [
            '<?php',        // PHP shells
            '<script',      // JavaScript injection
            'eval(',        // malicious execution
            'base64_decode',// encoded malware
            'system(',      // OS commands
            'shell_exec(',  // OS command injection
            'exec(',        // command execution
            'passthru(',    // dangerous function
            'proc_open(',   // process execution
        ];

        foreach ($bad_signatures as $bad) {
            if (stripos($contents, $bad) !== false) {
                AuditLogHelper::log('malware_blocked', [
                    'filename' => $file->getClientOriginalName(),
                    'signature' => $bad
            ]);


                return false; // file is unsafe
            }
        }

        return true; // file is safe
    }


}

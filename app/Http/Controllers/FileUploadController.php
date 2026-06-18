<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileUploadController extends Controller
{
    /**
     * Upload ANY file to a dynamic folder.
     */
    public function upload(Request $request)
    {
        // 1. Validation updated to accept 'file' and multiple file types (Images, PDFs, Videos, Audio, Docs)
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf,mp4,mp3,wav,zip,doc,docx|max:51200', // 50MB limit
            'folder_type' => 'required|string|regex:/^[a-zA-Z0-9_\-]+$/' // Prevent path traversal security issues
        ]);

        $folderType = $request->input('folder_type');
        $uploadPath = public_path("uploads/{$folderType}");

        // CRITICAL: Dynamically check if directory exists, create if not
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // 2. Process the file (using 'file' as the key)
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // 3. Move the file to the dynamically created public path
        $file->move($uploadPath, $fileName);

        $publicUrl = url("uploads/{$folderType}/{$fileName}");

        return response()->json([
            'success' => true,
            'public_url' => $publicUrl,
            'message' => 'File uploaded successfully'
        ], 201);
    }

    /**
     * Delete an uploaded file using its public URL.
     */
    public function delete(Request $request)
    {
        $request->validate([
            'file_url' => 'required|url'
        ]);

        $fileUrl = $request->input('file_url');
        $baseUrl = url('/');
        
        // Security Check: Ensure the URL belongs to this server
        if (strpos($fileUrl, $baseUrl) !== 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file URL: Does not belong to this server'
            ], 400);
        }

        // Extract the relative path from the URL
        $relativePath = str_replace($baseUrl . '/', '', $fileUrl);
        $absolutePath = public_path($relativePath);

        // Delete the file if it exists
        if (File::exists($absolutePath) && is_file($absolutePath)) {
            File::delete($absolutePath);
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File not found on server'
        ], 404);
    }
}
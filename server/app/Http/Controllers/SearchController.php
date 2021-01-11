<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * get hashtags and users by the search query
     *
     * @param Request $request
     * @return JSON ['hashtags', 'users']
     */
    function search(Request $request)
    {
        if (!$request->input('q')) {
            return response()->json(['hashtags' => [], 'users' => []]);
        }
        $q = $request->input('q');

        // get hashtags by search query
        $hashtags = array();
        $texts = Tweet::where('text', 'like', '%#' . $q . '%')
            ->orderBy('updated_at', 'desc')->limit(100)->pluck('text')->toArray();
        foreach ($texts as $text) {
            error_log($text);
            preg_match('/(#' . $q . '\b)|(#' . $q . '\w+)/', $text, $matches);
            if (!$matches) continue;
            error_log(json_encode($matches));
            if (array_key_exists($matches[0], $hashtags)) {
                $hashtags[$matches[0]] += 1;
            } else {
                $hashtags[$matches[0]] = 1;
            }
        }

        // get users by search query
        $select = [
            'users.id as user_id', 'users.avatar', 'users.fullname', 'users.username',
        ];
        $users = User::select($select)
            ->where('fullname', 'like', '%' . $q . '%')
            ->orWhere('username', 'like', '%' . $q . '%')
            ->orWhere('description', 'like', '%' . $q . '%')
            ->orWhere('location', 'like', $q . '%')
            ->orderBy('updated_at', 'desc')->limit(100)->get();

        return response()->json(['hashtags' => $hashtags, 'users' => $users]);
    }
}
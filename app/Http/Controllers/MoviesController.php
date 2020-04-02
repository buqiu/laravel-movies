<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    public $token;
    public $api_key;
    public $language;

    public function __construct()
    {
        $this->token = config('services.tmdb.token');
        $this->api_key = config('services.tmdb.api_key');
        $this->language = config('app.locale');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 热门电影
        $populars = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/movie/popular?api_key=$this->api_key&language=$this->language")
            ->json()['results'];

        // 正在播放
        $now_playing = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/movie/now_playing?api_key=$this->api_key&language=$this->language")
            ->json()['results'];

        // 电影类型
        $genres = collect(
            Http::withToken(config('services.tmdb.token'))
                ->get("https://api.themoviedb.org/3/genre/movie/list?api_key=$this->api_key&language=$this->language")
                ->json()['genres']
        )->mapWithKeys(
            function ($genre) {
                return [$genre['id'] => $genre['name']];
            }
        );

        return view(
            'movie.index',
            [
                'populars' => $populars,
                'now_playing' => $now_playing,
                'genres' => $genres,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 电影详情
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/movie/$id?api_key=$this->api_key&append_to_response=credits,videos,images&language=$this->language")
            ->json();

        return view(
            'movie.show',
            [
                'movie' => $movie,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

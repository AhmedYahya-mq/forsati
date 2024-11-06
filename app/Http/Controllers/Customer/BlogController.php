<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __invoke(Request $request)
    {
        // $scholarships=\App\Models\Scholarship::with(['degree_levels', 'specializations'])->take(10)->get();
        // $advertisements=\App\Models\Advertisement::take(10)->get();
        $searchQuery = $request->query('search');

        $blogs = $this->getFilteredBlogs($searchQuery);
        $topFiveBlogs = Blog::orderBy('visit', 'desc')->take(5)->get();
        return view('customer.blogs',
        [
            'user' => $request->user('web')?? null,
            // 'scholarships' => $scholarships,
            'blogs' =>$blogs,
            // "advertisements"=> $advertisements,
            "locale"=>$this->locale,
            "search"=> $request->input('search') ?? "",
            "topFiveBlogs"=> $topFiveBlogs,
        ]
        );
    }

    private function getFilteredBlogs( $searchQuery = null)
    {
        $query = Blog::query(); // استخدام query بدلاً من all

        // إضافة شروط البحث (إذا كانت موجودة)
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('id', $searchQuery)
                    ->orWhere('title_ar', 'like', "%$searchQuery%")
                    ->orWhere('title_en', 'like', "%$searchQuery%")
                    ->orWhere('description_ar', 'like', "%$searchQuery%")
                    ->orWhere('description_en', 'like', "%$searchQuery%");
            });
        }

        // استرجاع البيانات مع pagination
        return $query->paginate(self::perPage);
    }

    public function show($slug)
    {
        $blog = Blog::where("slug_en", $slug)->orWhere("slug_ar", $slug)->firstOrFail();
        
        $relatedBlogs = $this->getRelatedBlogs($this->locale, $blog);
        $topFiveBlogs = Blog::where('id', '!=', $blog->id)->orderBy('visit', 'desc')->take(5)->get();
        
        return view('customer.blog-details', [
            'user' => auth()->guard('web')->user() ?? null,
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs,
            'locale' => $this->locale,
            "topFiveBlogs"=> $topFiveBlogs,
        ]);
    }

    private function getRelatedBlogs($locale, Blog $blog ,$count = 4)
    {
        // البحث عن مقالات مشابهة بناءً على العنوان أو الوصف أو المحتوى
        $relatedBlogs = Blog::where('id', '!=',  $blog->id)
            ->where(function ($query) use ($locale,$blog) {
                $query->where('title_' . $locale, 'like', '%' . $blog->{'title_' . $locale} . '%')
                        ->orWhere('description_' . $locale, 'like', '%' . $blog->{'description_' . $locale} . '%')
                        ->orWhere('content_' . $locale, 'like', '%' . $blog->{'content_' . $locale} . '%');
            })
            ->inRandomOrder()
            ->take($count)
            ->get();

        // إذا لم يتم العثور على مقالات مشابهة، جلب أي مقالات عشوائية
        if ($relatedBlogs->isEmpty()) {
            $relatedBlogs = Blog::where('id', '!=', $blog->id)
                ->inRandomOrder()
                ->take($count)
                ->get();
        }

        return $relatedBlogs;
    }

    
}

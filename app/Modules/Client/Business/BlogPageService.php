<?php

namespace App\Modules\Client\Business;

use App\Models\Announcement;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Contact;
use App\Models\PopUp;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class BlogPageService
{
    public function getIndexData(Request $request, $category = null, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        $search = $request->input('search');
        $blogCategories = BlogCategory::whereHas('blogs')->active()->sorting()->get();

        $blogAll = Blog::with('category')
            ->whereHas('category', function ($active) {
                $active->where('active', 1);
            });

        if ($category) {
            $blogAll = $blogAll->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        }

        if ($search) {
            $blogAll = $blogAll->whereHas('category')->where('title', 'like', '%' . $search . '%');
        }

        $blogAll = $blogAll->active()->sorting()->paginate(15);

        $blogSeeAlso = Blog::with('category')
            ->whereHas('category', function ($active) {
                $active->where('active', 1);
            })
            ->whereNotIn('id', $blogAll->pluck('id'))
            ->active()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $popUp = PopUp::active()->first();
       
        return compact('blogCategories', 'blogAll', 'blogSeeAlso', 'popUp', 'tenantTheme','theme', 'themeData');
    }

    public function getInnerData($slug = null, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        if (!$slug) {
            return ['view' => view($theme->error('404'))];
        }

        $blogInner = Blog::with(['category'])
            ->whereHas('category')
            ->where('slug', $slug)
            ->active()
            ->sorting()
            ->first();

        if (!$blogInner) {
            return ['view' => view($theme->error('404'))];
        }

        $blogRelacionados = Blog::whereHas('category', function ($query) use ($blogInner) {
            $query->where('id', $blogInner->category->id);
        })
            ->where('id', '!=', $blogInner->id)
            ->active()
            ->sorting()
            ->take(4)
            ->get();

        $viewMores = Blog::whereHas('category', function ($query) use ($blogInner) {
            $query->where('id', '<>', $blogInner->category->id);
        })
            ->active()
            ->sorting()
            ->get();

        $blogCategories = BlogCategory::whereHas('blogs')->active()->sorting()->get();

        $announcements = Announcement::select(
            'exhibition',
            'link',
            'exhibition',
            'path_image',
            'active',
            'sorting',
        )
            ->where('exhibition', '=', 'mobile')
            ->orWhere('exhibition', '=', 'horizontal')
            ->active()
            ->sorting()
            ->get();

        $announcementVerticals = Announcement::select(
            'exhibition',
            'link',
            'exhibition',
            'path_image',
            'active',
            'sorting',
        )
            ->where('exhibition', '=', 'vertical')
            ->active()
            ->sorting()
            ->get();

        $contact = Contact::first();

        return compact(
            'contact',
            'viewMores',
            'announcementVerticals',
            'announcements',
            'blogInner',
            'slug',
            'blogCategories',
            'blogRelacionados', 
            'theme', 
            'themeData',
            'tenantTheme'
        );
    }
}

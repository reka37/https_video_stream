<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function Index() {
		$categories = Category::all();
		return view('category.index', ['categories' => $categories]);
	}
	
	  public function Addcategory(Request $request) {
		  if ($request->isMethod('post')) {
			 $categories = Category::create($request->all());
		

			return redirect()->back(); 
		  }
		
	}
}

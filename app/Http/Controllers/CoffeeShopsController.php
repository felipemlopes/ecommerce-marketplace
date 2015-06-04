<?php namespace Koolbeans\Http\Controllers;

use Illuminate\Http\Request;
use Koolbeans\Http\Requests;
use Koolbeans\Http\Requests\ApplicationCoffeeShopRequest;
use Koolbeans\Repositories\CoffeeShopRepository;

class CoffeeShopsController extends Controller
{
    /**
     * @var \Koolbeans\Repositories\CoffeeShopRepository
     */
    private $coffeeShop;

    /**
     * @param \Koolbeans\Repositories\CoffeeShopRepository $coffeeShop
     */
    public function __construct(CoffeeShopRepository $coffeeShop)
    {
        $this->coffeeShop = $coffeeShop;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function apply()
    {
        if (current_user()->isOwner()) {
            return redirect('home');
        }

        return view('coffee_shop.apply', ['coffeeShop' => $this->coffeeShop->newInstance()]);
    }

    /**
     * @param \Koolbeans\Http\Requests\ApplicationCoffeeShopRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeApplication(ApplicationCoffeeShopRequest $request)
    {
        $shop = $this->coffeeShop->newInstance($request->all());
        $shop->user()->associate(current_user());
        $shop->save();

        return redirect(route('home'))->with('messages',
            ['success' => 'Your request has been sent trough! We shall contact you back very soon, stay close!']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReview(Request $request, $id)
    {
        $rating = $request->input('rating');
        $review = $request->input('review');

        if ($rating > 5 || $rating < 1) {
            return redirect()->back()->with('special-message', ['warning' => "An error occured. Please review again."]);
        }

        $coffeeShop = $this->coffeeShop->find($id);
        $coffeeShop->addReview($review, $rating);

        return redirect()->back()->with('special-message', ['success' => "Your review has been delivered!"]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $coffeeShop = $this->coffeeShop->find($id);
        $bestReview = $coffeeShop->getBestReview();

        return view('coffee_shop.show', compact('coffeeShop', 'bestReview'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return string
     */
    public function update(Request $request, $id)
    {
        $coffeeShop        = $this->coffeeShop->find($id);
        $coffeeShop->about = $request->input('about');
        $coffeeShop->save();

        return $coffeeShop->about;
    }
}

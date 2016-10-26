<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DocumentController extends Controller
{
    // 总榜
    public function rankTopAll()
    {
    	if($this->request->expert_code == 'zhejiangtsw'){
			return view('document/ranktopall_zjtsw');
		}

        return view('document/ranktopall');
    }

    // 周榜
    public function rankTopWeek()
    {
    	if($this->request->expert_code == 'zhejiangtsw'){
			return view('document/ranktopweek_zjtsw');
		}

        return view('document/ranktopweek');
    }

    // 奖励
    public function rewards()
    {
    	if($this->request->expert_code == 'zhejiangtsw'){
			return view('document/rewards_zjtsw');
		}

        return view('document/rewards');
    }

    // 奖励
    public function test()
    {
        $input = $this->request->all();
        echo "<h3>Input:</h3>";
        echo "<pre>";
        var_dump($input);
        echo "</pre>";

        echo "<h3>Headers:</h3>";
        echo "<pre>";
        var_dump($this->request->header());
        echo "</pre>";

        echo "<h3>App Auth Header:</h3>";
        echo "<pre>";
        var_dump($this->request->header('Token-key'));
        var_dump($this->request->header('Token-Secret'));
        echo "</pre>";
    }
}

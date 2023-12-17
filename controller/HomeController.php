<?php
require_once(__DIR__ . "/../model/GameModel.php");

class HomeController extends BaseController
{
    protected $games;
    protected $historyPlay;

    public function __construct()
    {
        $this->games = new GameModel;
        $this->historyPlay = new HistoryPlayModel;
    }


    public function index()
    {
        $ratioChan = $this->games->getInfoGame("C");
        $ratioLe = $this->games->getInfoGame("L");
        $ratioTai = $this->games->getInfoGame("T");
        $ratioXiu = $this->games->getInfoGame("X");

        $getPlayByUsername = $this->historyPlay->getPlayerByUsername(getSessionUser());
        $getAllDataHistory = $this->historyPlay->getAllDataHistory();
        return view("client/index", get_defined_vars());
    }
}

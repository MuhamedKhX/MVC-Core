<?php



class AuthMiddleware extends BaseMiddleware
{

    public array $actions = [];

    /**
     * AuthMiddleware constructor.
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if(\app\core\Application::Guest())
        {
            if(empty($this->actions) || in_array(\app\core\Controller::$action, $this->actions))
            {
                throw new exceptionX();
            }
        }
    }
}
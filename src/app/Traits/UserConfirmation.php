<?php namespace Afrittella\BackProject\Traits;
/**
 * UserConfirmation Trait
 * checks if User model is confirmed
 *
 * @author Andrea Frittella <a.frittella@sintab.it>
*/

trait UserConfirmation
{
    protected $confirmation_field = 'confirmed';
    protected $confirmation_token_field = 'confirmation_code';

    public function confirm($code)
    {
    if ($this->{$this->confirmation_token_field} == $code && $this->isPendingConfirmation()) {
        $this->{$this->confirmation_token_field} = null;
        $this->{$this->confirmation_field} = 1;
        $this->save();
        return true;
    }

    return false;
    }

    public function isConfirmed()
    {
    return (bool) $this->{$this->confirmation_field};
    }

    public function hasConfirmationCode()
    {
    return !is_null($this->{$this->confirmation_token_field} );
    }

    public function isPendingConfirmation()
    {
    return !$this->isConfirmed() && $this->hasConfirmationCode();
    }

    public function getConfirmationField()
    {
    return $this->confirmation_field;
    }

    public function getConfirmationTokenField()
    {
    return $this->confirmation_token_field;
    }

    public function generateConfirmationCode()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }
}

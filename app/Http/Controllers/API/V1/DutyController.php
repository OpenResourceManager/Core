<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Duty\DutiesViewed;
use App\Events\Api\Duty\DutyRestored;
use App\Events\Api\Duty\DutyViewed;
use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use App\Http\Transformers\DutyTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DutyController extends ApiController
{

    /**
     * DutyController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'duty';
    }

    /**
     * Show all Duty resources
     *
     * Get a paginated array of Duties.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $duties = Duty::paginate($this->resultLimit);
        event(new DutiesViewed($duties->pluck('id')->toArray()));
        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * Show a Duty
     *
     * Display a Duty by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Duty::findOrFail($id);
        event(new DutyViewed($item));
        return $this->response->item($item, new DutyTransformer);
    }

    /**
     * Show Duty by Code
     *
     * Display a Duty by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Duty::where('code', $code)->firstOrFail();
        event(new DutyViewed($item));
        return $this->response->item($item, new DutyTransformer);
    }

    /**
     * Get Duties for an Account
     *
     * Shows a list of duties owned by an account.
     *
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function showForAccount($id)
    {
        $duties = Account::findOrFail($id)->duties()->paginate($this->resultLimit);
        event(new DutiesViewed($duties->pluck('id')->toArray()));
        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * Get Duties for an Account by Username
     *
     * Shows a list of duties owned by an account from it's username.
     *
     * @param string $username
     * @return \Dingo\Api\Http\Response
     */
    public function showForUsername($username)
    {
        $duties = Account::where('username', $username)->firstOrFail()->duties()->paginate($this->resultLimit);
        event(new DutiesViewed($duties->pluck('id')->toArray()));
        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * Get Duties for an Account by Identifier
     *
     * Shows a list of duties owned by an account from it's identifier.
     *
     * @param string $identifier
     * @return \Dingo\Api\Http\Response
     */
    public function showForIdentifier($identifier)
    {
        $duties = Account::where('identifier', $identifier)->firstOrFail()->duties()->paginate($this->resultLimit);
        event(new DutiesViewed($duties->pluck('id')->toArray()));
        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * Store/Update/Restore Duty
     *
     * Create or update Duty information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'alpha_dash|required|min:3|max:15',
            'label' => 'string|required|max:50|min:3',
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());

        if ($toRestore = Duty::onlyTrashed()->where('code', $data['code'])->first()) {
            $toRestore->restore();
        }
        $trans = new DutyTransformer();
        $item = Duty::updateOrCreate(['code' => $data['code']], $data);
        $item = $trans->transform($item);
        return $this->response->created(route('api.duties.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Duty
     *
     * Deletes the specified Duty by it's ID or Code attribute.
     *
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'code' => 'string|required_without:id|exists:duties,code,deleted_at,NULL',
            'id' => 'integer|required_without:code|exists:duties,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', $validator->errors()->all());

        $deleted = (array_key_exists('id', $data)) ? Duty::destroy($data['id']) : Duty::where('code', $data['code'])->firstOrFail()->delete();

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure($this->noun);
    }
}

<?php
class Controller_Datingpackageinvitation extends Controller_Template{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

	public function action_index()
	{
		$data['datingpackageinvitations'] = Model_Datingpackageinvitation::find('all');
		$this->template->title = "Datingpackageinvitations";
		$this->template->content = View::forge('datingpackageinvitation/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('datingpackageinvitation');

		if ( ! $data['datingpackageinvitation'] = Model_Datingpackageinvitation::find($id))
		{
			Session::set_flash('error', 'Could not find datingpackageinvitation #'.$id);
			Response::redirect('datingpackageinvitation');
		}

		$this->template->title = "Datingpackageinvitation";
		$this->template->content = View::forge('datingpackageinvitation/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Datingpackageinvitation::validate('create');
			
			if ($val->run())
			{
				$datingpackageinvitation = Model_Datingpackageinvitation::forge(array(
					'from_member_id' => Input::post('from_member_id'),
					'to_member_id' => Input::post('to_member_id'),
					'date_invited' => Input::post('date_invited'),
					'status' => Input::post('status'),
				));

				if ($datingpackageinvitation and $datingpackageinvitation->save())
				{
					Session::set_flash('success', 'Added datingpackageinvitation #'.$datingpackageinvitation->id.'.');

					Response::redirect('datingpackageinvitation');
				}

				else
				{
					Session::set_flash('error', 'Could not save datingpackageinvitation.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = 'WHERE WE ALL MEET &raquo; Datingpackageinvitations';
		$this->template->content = View::forge('datingpackageinvitation/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('datingpackageinvitation');

		if ( ! $datingpackageinvitation = Model_Datingpackageinvitation::find($id))
		{
			Session::set_flash('error', 'Could not find datingpackageinvitation #'.$id);
			Response::redirect('datingpackageinvitation');
		}

		$val = Model_Datingpackageinvitation::validate('edit');

		if ($val->run())
		{
			$datingpackageinvitation->from_member_id = Input::post('from_member_id');
			$datingpackageinvitation->to_member_id = Input::post('to_member_id');
			$datingpackageinvitation->date_invited = Input::post('date_invited');
			$datingpackageinvitation->status = Input::post('status');

			if ($datingpackageinvitation->save())
			{
				Session::set_flash('success', 'Updated datingpackageinvitation #' . $id);

				Response::redirect('datingpackageinvitation');
			}

			else
			{
				Session::set_flash('error', 'Could not update datingpackageinvitation #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$datingpackageinvitation->from_member_id = $val->validated('from_member_id');
				$datingpackageinvitation->to_member_id = $val->validated('to_member_id');
				$datingpackageinvitation->date_invited = $val->validated('date_invited');
				$datingpackageinvitation->status = $val->validated('status');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('datingpackageinvitation', $datingpackageinvitation, false);
		}

		$this->template->title = 'WHERE WE ALL MEET &raquo; Datingpackageinvitations';
		$this->template->content = View::forge('datingpackageinvitation/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('datingpackageinvitation');

		if ($datingpackageinvitation = Model_Datingpackageinvitation::find($id))
		{
			$datingpackageinvitation->delete();

			Session::set_flash('success', 'Deleted datingpackageinvitation #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete datingpackageinvitation #'.$id);
		}

		Response::redirect('datingpackageinvitation');

	}


}

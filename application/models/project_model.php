<?php
class Project_model extends CI_Model {
  public $session_data;
  public function __construct()
  {
    $this->load->database();
  }

  public function get_projects($cid)
  {
    $uid = $this->tank_auth_my->get_user_id();
    $this->db->select("p.project_id, p.project_name, p.status", false);

    $this->db->from('projects p');
    $this->db->where('p.uid', $uid);
    $this->db->where('p.cid', $cid);
    $this->db->order_by("project_id", "desc");
    $query = $this->db->get();
    $projects = $query->result_array();

    if ($query->num_rows() > 0)
    {

      foreach ($projects as &$project) {

        $query = $this->db->order_by('id', 'desc')->get_where('tasks', array('project_id' => $project['project_id']));

        foreach ($query->result() as $task) {

          if (!empty($task)) {
            $project['tasks'][] = $task;

            $query2 = $this->db->get_where('timers', array('task_id' => $task->id));

            foreach ($query2->result() as $timer) {
              $task->timers[] = $timer;
            }
          }
        }
      }

      return $projects;
    }

    else {

      return;
    }
  }


  public function get_project($project_id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('projects');
    $this->db->where('id', $project_id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function set_project($data)
  {
    $uid = $this->tank_auth_my->get_user_id();
    $data = array(
      'project_name' => $data['prj_name'], 'uid' => $uid, 'cid' => $data['cid']
    );
    $this->db->insert('projects', $data);
    $data['project_id'] = $this->db->insert_id();

    return $data;
  }

  public function update_project($data)
  {
    $data = array(
      'project_name' => $data['prj_name'], 'uid' => $uid, 'cid' => $data['cid']
    );
    $this->db->where('id', $data['id']);
    $this->db->update('project', $data);

    return;
  }

  public function delete_project($id)
  {
    $uid = $this->tank_auth_my->get_user_id();

    $this->db->start_cache();
    $this->db->select('*', false);
    $this->db->where('cid', $id);
    $this->db->where('uid', $uid);
    $this->db->from('projects');
    $this->db->stop_cache();

    $query = $this->db->get();
    $common = $query->result_array();
    $this->db->delete('projects');
    $this->db->flush_cache();

    foreach ($projects as $project) {
      // Delete all associated items
      $this->db->where_in('project_id', $project['id']);
      $this->db->delete('task');
    }
    // TODO Delete all associated tasks
    // TODO Delete all associated timers

    $this->db->where('id', $id);
    $this->db->where('uid', $uid);
    $this->db->limit(1);
    $this->db->delete('projects');

    return;
  }

  public function get_task($task_id = FALSE)
  {
    $uid = $this->tank_auth_my->get_user_id();
    $this->db->select('*');
    $this->db->from('tasks');
    $this->db->where('id', $task_id);
    $this->db->where('uid', $uid);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function set_task($data)
  {
    $uid = $this->tank_auth_my->get_user_id();
    $data = array(
      'uid' => $uid, 'project_id' => $data['project_id'], 'cid' => $data['cid'], 'task_name' => $data['task_name'], 'time_estimate' => $data['time_estimate'], 'rate' => $data['rate'], 'date' => date('Y-m-d H:i:s')
    );

    $this->db->insert('tasks', $data);
    $data['id'] = $this->db->insert_id();
    return $data;
  }

  public function update_task($data)
  {
    $id = $data['id'];
    $uid = $this->tank_auth_my->get_user_id();
    $tdata = array(
      'task_name' => $data['task_name'], 'time_estimate' => $data['time_estimate'], 'rate' => $data['rate']
    );
    $this->db->where('id', $id);
    return $this->db->update('tasks', $tdata);
  }

  public function delete_task($data)
  {
    $id = $data['id'];
    $uid = $this->tank_auth_my->get_user_id();

    $this->db->start_cache();
    $this->db->select('*', false);
    $this->db->where('id', $id);
    $this->db->where('uid', $uid);
    $this->db->from('tasks');
    $this->db->limit(1);
    $this->db->stop_cache();

    $query = $this->db->get();
    $this->db->delete('tasks');
    $this->db->flush_cache();

    if ($query->num_rows() > 0)
    {
      // Delete all associated timers
      $this->db->where('task_id', $id);
      $this->db->delete('timers');
    }
  }

  public function set_timer()
  {
    $task_id = $this->input->post('task_id');
    $client_id = $this->input->post('client_id');
    $time = $this->input->post('timer');
    $description = $this->input->post('description');

    $data = array(
      'task_id' => $task_id,
      'description' => $description,
      'time_started' => date('Y-m-d H:i:s'),
      'time' => $time
    );

    return $this->db->insert('timers', $data);
  }

}

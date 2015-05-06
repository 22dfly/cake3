<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class PostsController extends AppController
{

    public function index()
    {
        $this->set('posts', $this->Posts->find('all'));
    }

    public function view($id = null)
    {
        if (!$this->Posts->exists(['id' => $id])) {
            $this->Flash->error(__('The post is not existed.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set('post', $this->Posts->get($id));
    }

    public function add()
    {
        $post = $this->Posts->newEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
        $this->set('post', $post);
    }

    public function edit($id = null)
    {
        if (!$this->Posts->exists(['id' => $id])) {
            $this->Flash->error(__('The post is not existed.'));
            return $this->redirect(['action' => 'index']);
        }

        $post = $this->Posts->get($id);
        if ($this->request->is(['post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        $this->set('post', $post);
    }
}

<?php
declare(strict_types=1);

namespace SeoBakery\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Model\Table\SeoMetadataTable;

/**
 * SeoMetadata Controller
 *
 * @property SeoMetadataTable $SeoMetadata
 * @method SeoMetadata[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeoMetadataController extends AppController
{
    /**
     * Index method
     *
     * @return void Renders view
     */
    public function index()
    {
        $query = $this->SeoMetadata->find();

        $table_alias = $this->getRequest()->getQuery('table_alias', false);
        if ($table_alias !== false) {
            $table_alias = trim($table_alias) === '' ? null : $table_alias;
            $query->where([
                'table_alias IS' => $table_alias,
            ]);
        }

        $missing_field = $this->getRequest()->getQuery('missing', false);
        if (in_array($missing_field, SeoMetadataTable::MISSING_FIELDS_OPTIONS)) {
            $query->where([
                $missing_field . ' IS' => null,
            ]);
        }

        $optimized = $this->getRequest()->getQuery('optimized', false);
        if (in_array($optimized, ['True', 'False'])) {
            $is = $optimized === 'True' ? 'IS NOT' : 'IS';
            $query->where([
                'canonical ' . $is => null,
                'meta_title ' . $is => null,
                'meta_description ' . $is => null,
            ]);
        }

        $seoMetadata = $this->paginate($query);
        $this->set(compact('seoMetadata'));
    }

    /**
     * View method
     *
     * @param string|null $id Seo Metadata id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seoMetadata = $this->SeoMetadata->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('seoMetadata'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seo Metadata id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seoMetadata = $this->SeoMetadata->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['meta_keywords'] = is_string($data['meta_keywords']) ? explode(',', $data['meta_keywords']) : $data['meta_keywords'];
            $seoMetadata = $this->SeoMetadata->patchEntity($seoMetadata, $data);
            if ($this->SeoMetadata->save($seoMetadata)) {
                $this->Flash->success(__('The seo metadata has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seo metadata could not be saved. Please, try again.'));
        }
        $this->set(compact('seoMetadata'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seo Metadata id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete(string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $seoMetadata = $this->SeoMetadata->get($id);
        if ($this->SeoMetadata->delete($seoMetadata)) {
            $this->Flash->success(__('The seo metadata has been deleted.'));
        } else {
            $this->Flash->error(__('The seo metadata could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

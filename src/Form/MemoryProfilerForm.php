<?php

namespace Drupal\memory_profiler\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Memory profiler module settings.
 *
 * @internal
 */
class MemoryProfilerForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'memory_profiler_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['memory_profiler.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('memory_profiler.settings');

    $form['appearence'] = [
      '#type' => 'details',
      '#title' => $this->t('Appearance'),
      '#open' => TRUE,
    ];
    $form['appearence']['watchdog'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Log statistics into watchdog'),
      '#default_value' => $site_config->get('watchdog'),
      '#description' => $this->t('If checked, the message will be logged via watchdog system.'),
    ];
    $form['appearence']['echo'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Log statistics into page footer'),
      '#default_value' => $site_config->get('echo'),
      '#description' => $this->t('If checked, the message will be printed at the end of the page.'),
    ];
    $form['appearence']['anonymous'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Log statistics for anonymous user'),
      '#default_value' => $site_config->get('anonymous'),
      '#description' => $this->t('If checked, each request from anonymous user will be logged.'),
    ];

    $form['track'] = [
      '#type' => 'details',
      '#title' => $this->t('Track'),
      '#open' => TRUE,
    ];
    $form['track']['memory'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Min memory usage to track'),
      '#default_value' => $site_config->get('memory'),
      '#description' => $this->t('If not empty or more then 0, will be tracked only higher values.'),
    ];
    $form['track']['time'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Min execution time to track'),
      '#default_value' => $site_config->get('time'),
      '#description' => $this->t('If not empty or more then 0, will be tracked only higher values (e.g. 4 or 5.5).'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('memory_profiler.settings')
      ->set('watchdog', $form_state->getValue('watchdog'))
      ->set('echo', $form_state->getValue('echo'))
      ->set('anonymous', $form_state->getValue('anonymous'))
      ->set('memory', $form_state->getValue('memory'))
      ->set('time', $form_state->getValue('time'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}

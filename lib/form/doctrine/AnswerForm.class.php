<?php
class AnswerForm extends BaseAnswerForm
{
	public function configure()
	{
		//Задание будет задаваться принудительно.
		unset($this['task_id']);
		$this->setWidget('task_id', new sfWidgetFormInputHidden());
		$this->setValidator('task_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Task'))));
		//Прокомментируем пустое значение
		$this->getWidget('team_id')->setOption('add_empty', '(Для всех команд)');

		//Русифицируем:
		$this->getWidgetSchema()->setLabels(array(
			'name' => 'Название:',
			'value' => 'Значение:',
			'info' => 'Описание:',
			'team_id' => 'Только для:',
		));

		$this->getWidgetSchema()->setHelps(array(
			'name' => 'В процессе игры известно только организаторам.',
			'value' => 'Значение, которое вводится для зачета ответа.|Пробелы недопустимы.|Регистр букв при проверке ответа не учитывается.',
			'info' => 'Текст, который виден игрокам и позволяет им различать ответы (например, код опасности).|Не пишите сюда информацию облегчающую разгадывание!',
			'team_id' => 'Правильным будет только для указанной команды.',
		));
	}
}

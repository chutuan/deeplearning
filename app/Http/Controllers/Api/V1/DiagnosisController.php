<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\HistoryRepository;
use Illuminate\Http\Request;
use App\Diagnose;
use App\DiagnoseHistory;

class DiagnosisController extends BaseController
{
    protected $repository;

    public function __construct(HistoryRepository $repository)
    {
        $this->repository = $repository;
    }
  public function store(Request $request)
  {
    $symptoms = $request->get('symptoms');
    $trainingInputs = [];
    $trainingOutputs = [];
    $diagnosis = Diagnose::all();
    foreach($diagnosis as $diagnose)
    {
      array_push($trainingInputs,'[' . $diagnose->symptoms . ']');
      array_push($trainingOutputs, $diagnose->result);
    }
    $trainingInputs = implode(',', $trainingInputs);
    $trainingOutputs = '[' . implode(',', $trainingOutputs) . ']';
    file_put_contents(app_path('NeuralNetwork.py'), 
    "from numpy import exp, array, random, dot\r\n
class NeuralNetwork():
    def __init__(self):
        random.seed(1)
        self.weights = 2 * random.random((14, 1)) - 1
    def __sigmoid(self, x):
        # Ham chuan hoa
        # YT = 1 / (1 + exp(e(-Y)))
        return 1 / (1 + exp(-x))
    def __sigmoid_derivative(self, x):
        return x * (1 - x)
    def train(self, training_set_inputs, training_set_outputs, number_of_training_iterations):
        for iteration in xrange(number_of_training_iterations):
            output = self.think(training_set_inputs)
            # Cacuated Delta Error
            error = training_set_outputs - output
            # Adjust = error * inputs * (x * (1 - x))
            adjustment = dot(training_set_inputs.T, error * self.__sigmoid_derivative(output))
            self.weights += adjustment
    def think(self, inputs):
        # Y = Sum(Input[1..n]*weights)
        total = dot(inputs, self.weights)
        return self.__sigmoid(total)
if __name__ == '__main__':
    neural_network = NeuralNetwork()
    training_inputs = array([{$trainingInputs}])
    training_outputs = array([{$trainingOutputs}]).T
    neural_network.train(training_inputs, training_outputs, 100000)
    print neural_network.think(array([{$symptoms}]))");
    
    $neural = escapeshellcmd('python ' . app_path('NeuralNetwork.py'));
    $perCent = number_format(preg_replace("/[\]\[]/", "", shell_exec($neural)) * 100, 2);
    if($perCent < 40)
    {
        $message = "Trẻ hoàn toàn không có các biểu hiện của bệnh tự kỷ.";
        $advice = "Chăm sóc trẻ chu đáo";
    }elseif($perCent < 60)
    {
        $message = "Trẻ có một số triệu chứng tương đối rõ ràng của bệnh tự kỷ.";
        $advice = "Chăm sóc trẻ và chia sẻ với trẻ nhiều hơn";
    }else
    {
        $message = "Trẻ có các triệu chứng rất rõ ràng của bệnh tự kỷ.";
        $advice = "Chăm sóc trẻ và chia sẻ với trẻ. Đưa trẻ đến bệnh viên nhi để bác sĩ có hướng điều trị";
    }
    \Auth::user()->diagnoseHistories()->create([
        'symptoms' => $symptoms,
        'per_cent' => $perCent,
        'message' => $message,
        'advice' => $advice
    ]);

    return $this->responseSuccess('Diagnose Successfully', [
        "per_cent" => shell_exec($neural),
        "message" => $message,
        "advice" => $advice
    ]);
  }

  public function histories()
  {
    $this->repository->skipPresenter(false)->scopeQuery(function($query)
    {
        return $query->where('user_id', '=', \Auth::user()->id);
    })->orderBy('updated_at', 'DESC');
    $histories = $this->repository->all();

    return $this->responseSuccess('Get Histories Successfully', ['histories' => $histories]);
  }
}
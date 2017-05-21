from numpy import exp, array, random, dot

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
    training_inputs = array([[2,3,1,2,2,1,2,3,0,3,1,2,3,2],[2,0,2,0,3,1,0,3,1,2,3,1,2,0],[2,4,4,2,0,0,0,4,4,3,0,1,1,4],[2,4,4,4,3,1,4,3,4,2,2,4,4,4],[1,3,4,4,3,3,1,3,0,3,2,4,4,2],[4,0,1,0,4,2,0,0,0,2,2,1,2,2],[4,1,4,4,1,2,1,3,2,4,4,3,0,0],[4,2,2,1,1,4,1,3,4,0,2,1,1,0],[2,4,3,4,3,0,1,2,4,2,1,2,4,1],[0,4,0,0,3,1,1,2,1,3,0,2,2,3],[3,3,1,0,0,1,0,4,2,0,1,3,3,3],[1,1,1,0,3,2,0,4,1,0,2,0,0,0],[0,2,2,4,1,3,4,1,1,3,2,2,0,3],[4,0,1,0,3,4,1,3,4,4,4,4,2,1],[4,3,3,1,0,4,3,4,2,2,1,2,1,3],[3,0,0,3,2,2,1,3,2,1,0,0,0,3],[0,4,1,3,0,0,1,4,2,4,0,2,0,4],[0,0,2,4,1,4,3,4,3,2,1,0,3,1],[1,1,1,1,1,4,0,0,2,2,1,0,1,1]])
    training_outputs = array([[1,0.5,0,0.75,0.5,1,0.75,1,1,0.75,0,0.25,0.5,0.75,0.25,1,0,0.75,0.25]]).T
    neural_network.train(training_inputs, training_outputs, 100000)
    print neural_network.think(array([1,1,1,1,1,4,0,0,2,2,1,0,1,1]))